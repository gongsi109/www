<?php


namespace app\admin\controller;


class Document extends AdminControl {

//    系统文章管理首页
    public function index(){
        $document_model = model('document');
        $doc_list = $document_model->getDocumentList();
        $this->assign('doc_list',$doc_list);
        return $this->fetch();
    }

//    系统文章编辑
    public function edit(){
        if(request()->isPost()){

        }else {
            $id = intval(input('param.document_id'));
            if(empty($id)){
                $this->error('xxxx');
            }
            $document_model = model('document');
            $doc = $document_model->getOneDocumentById($id);

            $upload_model = model('upload');
            $condition['upload_type'] = '4';
            $condition['item_id'] = $doc['document_id'];
            $file_upload = $upload_model->getUploadList($condition);
            if(is_array($file_upload)){
                foreach($file_upload as $k=>$v){
                    $file_upload[$k]['upload_path']= $file_upload['$k']['file_name'];
                }
            }

            $this->assign('PHPSESSID',session_id());
            $this->assign('file_upload',$file_upload);
            $this->assign('doc',$doc);
            return $this->fetch();
        }
    }

}
