<?php
/**
 * Created by PhpStorm.
 * User: LH
 * Date: 2019/2/25
 * Time: 19:18
 */

namespace module\core\upfile;


use CAction;
use CC;
use CC\util\common\server\SessionAbs;
use CC\util\external\alioss\Alioss;
use CFileUpload;
use CRequest;

class CoreUpfileIndexAction extends CAction
{

    public function execute(CRequest $request)
    {
        if (empty($_FILES)) {
            throw new \CErrorException(CC::t('tips_upload_file_fail'));
        }
        ini_set("max_execution_time", "0");
        $name = array_keys($_FILES)[0];
        $fileUpload = new CFileUpload();
        $msgArr = $fileUpload->save($name);
        $msgArr = $fileUpload->thumbPic($request->getParams('thumbparam'));
        $msgArr['url'] = $request->getAbsoluteUrl($msgArr['url']);
        $msgArr['thumburl'] = $request->getAbsoluteUrl($msgArr['thumburl']);
        $msgArr['servertime'] = time();


        $is_sign_alioss = $request->getParams('is_sign_alioss', $this->isSignForDefault());
        if ($request->getParams('name') == 'kindeditor') {
            if ($msgArr['ok']) {
                $msgArr['error'] = 0;
            } else {
                $msgArr['error'] = $msgArr['msg'];
            }
        } else {
            $msgArr['error'] = $msgArr['msg'];
            if (CC::env()->alioss['open']) {
                $alioss = Alioss::instance();
                $type = $request->getParams('type');
                $com_id = SessionAbs::getComID();
                $url = $alioss->getPathForUrl($msgArr['url'], $type, $com_id);
                $attempts = 0;
                do {
                    if ($alioss->uploadFile($fileUpload->getAbsPath(), $url)) {
                        unlink($fileUpload->getAbsPath());
                        $msgArr['url'] = $alioss->getSignUrl($url, $is_sign_alioss);

                        $makethumb = $request->getParams('makethumb', false);
                        if ($makethumb) {
                            $thumbparam = $request->getParams('thumbparam', false);
                            $w = 100;
                            $h = 100;
                            if ($thumbparam) {
                                $thumbparamArr = json_decode($thumbparam, true);
                                $w = $thumbparamArr['maxWidth'];
                                $h = $thumbparamArr['maxHeight'];
                            }
                            $msgArr['thumburl'] = $alioss->getThumbSignUrl($url, $w, $h);
                        }
                        return new \CStringData(json_encode($msgArr));
                    } else {
                        $attempts++;
                    }
                } while ($attempts < 3);
            }
        }
        return new \CStringData(json_encode($msgArr));
    }

    protected function isSignForDefault()
    {
        return !$this->request->isMobile();
    }
}