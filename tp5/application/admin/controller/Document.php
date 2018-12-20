<?php


namespace app\admin\controller;


class Document extends AdminControl {

    public function index(){
        $document_model = model('document');
        $doc_list = $document_model->getDocumentList();
    }
}
