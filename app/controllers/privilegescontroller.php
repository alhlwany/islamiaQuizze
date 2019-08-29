<?php
namespace PHPMVC\Controllers;
use PHPMVC\LIB\HelperMordy;
use PHPMVC\LIB\InputFilterMordy;
use PHPMVC\lib\Messenger;
use PHPMVC\Models\PrivilegeModel;
use PHPMVC\Models\UserGroupPrivilegeModel;

class PrivilegesController extends AbstractController
{
    use InputFilterMordy;
    use HelperMordy;

    private $_createActionRoles =
    [

    ];

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('privileges.default');

        $this->_data['privileges'] = PrivilegeModel::getAll();

        $this->_view();
    }

    // TODO: we need to implement csrf prevention
    public function createAction()
    {
        $this->language->load('template.common');
        $this->language->load('privileges.labels');
        $this->language->load('privileges.create');

        if(isset($_POST['add'])) {
            $privilege = new PrivilegeModel();
            $privilege->PrivilegeTitle = $this->filterString($_POST['PrivilegeTitle']);
            $privilege->Privilege = $this->filterString($_POST['Privilege']);
            if($privilege->save())
            {
//                $this->messenger->add('تم حفظ الصلاحية بنجاح', Messenger::APP_MESSAGE_ERROR);
               // $this->messenger->add('تم حفظ الصلاحية بنجاح');
                $this->redirect('/privileges');
            }
        }

        $this->_view();
    }

    public function editAction()
    {

        $id = $this->filterInt($this->_params[0]);
        $privilege = PrivilegeModel::getByPK($id);

        if($privilege === false) {
            $this->redirect('/privileges');
        }

        $this->_data['privilege'] = $privilege;

        $this->language->load('template.common');
        $this->language->load('privileges.labels');
        $this->language->load('privileges.edit');

        if(isset($_POST['edit'])) {
            $privilege->PrivilegeTitle = $this->filterString($_POST['PrivilegeTitle']);
            $privilege->Privilege = $this->filterString($_POST['Privilege']);
            if($privilege->save())
            {
                $this->redirect('/privileges');
            }
            
           // $this->messenger->add('تم تعديل الصلاحية بنجاح', Messenger::APP_MESSAGE_WARNING);
        }

        $this->_view();
    }

    public function deleteAction()
    {

        $id = $this->filterInt($this->_params[0]);
        $privilege = PrivilegeModel::getByPK($id);

        if($privilege === false) {
            $this->redirect('/privileges');
        }

        $groupPrivileges = UserGroupPrivilegeModel::getBy(['PrivilegeId' => $privilege->PrivilegeId]);
        if(false !== $groupPrivileges) {
            foreach ($groupPrivileges as $groupPrivilege) {
                $groupPrivilege->delete();
            }
        }

        if($privilege->delete())
        {
            $this->messenger->add('تم حذف الصلاحية بنجاح', Messenger::APP_MESSAGE_ERROR);
            $this->redirect('/privileges');
        }
    }

}