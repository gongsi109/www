<?php
/**
 * 营销设置
 */

namespace app\admin\controller;


use think\Lang;
use think\Validate;
class Operation extends AdminControl
{
public function _initialize()
{
    parent::_initialize(); // TODO: Change the autogenerated stub
    Lang::load(APP_PATH.'admin/lang/'.config('default_lang').'/config.lang.php');
}

    /**
     * 基本设置
     */
    public function setting(){
        $config_model = model('config');
        if (request()->isPost()) {
            $update_array = array();
            $update_array['promotion_allow'] = intval(input('post.promotion_allow'));
            $update_array['groupbuy_allow'] = intval(input('post.groupbuy_allow'));
            $update_array['points_isuse'] = intval(input('post.points_isuse'));
            $update_array['pointshop_isuse'] = input('post.pointshop_isuse');
            $update_array['voucher_allow'] = input('post.voucher_allow');
            $update_array['pointprod_isuse'] = input('post.pointprod_isuse');
            $update_array['points_reg'] = intval(input('post.points_reg'));
            $update_array['points_login'] = intval(input('post.points_login'));
            $update_array['points_comments'] = intval(input('post.points_comments'));
            $update_array['points_orderrate'] = intval(input('post.points_orderrate'));
            $update_array['points_ordermax'] = intval(input('post.points_ordermax'));
            $update_array['points_signin'] = intval(input('post.points_signin'));
            $update_array['points_invite'] = intval(input('post.points_invite'));
            $update_array['points_rebate'] = intval(input('post.points_rebate'));

            $result = $config_model->editConfig($update_array);
            if ($result === true) {
                $this->log(lang('ds_edit') . lang('ds_operation') . lang('ds_operation_set'), 1);
                $this->success(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        } else {
            $list_setting = $config_model->getConfigList();
            $this->assign('list_setting', $list_setting);
            $this->setAdminCurItem('index');
            return $this->fetch('index');
        }

    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => '基本设置',
                'url' => url('Operation/setting')
            ),
        );
        return $menu_array;
    }
}