<?php
//filename : module/Authentication/src/Authentication/Controller/AuthController.php
namespace Authentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Authentication\Storage\IdentityManagerInterface;

class AuthController extends AbstractActionController
{
    protected $identityManager;

    //we will inject authService via factory
    public function __construct(IdentityManagerInterface $identityManager)
    {
        $this->identityManager = $identityManager;
    }

    public function indexAction()
    {
       
        if ($this->identityManager->hasIdentity()) {
            //redirect to success controller...
            return $this->redirect()->toRoute('home');
        }
        
        $form = $this->getServiceLocator()->get('Form\LoginForm');
        $viewModel = new ViewModel();
        //initialize error...
        $viewModel->setVariable('error', '');
        $viewModel->setVariable('message', '');
        //authentication block...
        if($this->getRequest()->isPost()){
            $post = $this->params()->fromPost();
            $form->isValid($this->getRequest());
            $messagesForm = $form->getMessages();
            if(empty($messagesForm)){
                $this->authenticate($form, $viewModel);
            }
        }
        $viewModel->setVariable('form', $form);
        
        $messages = $this->flashMessenger()->getMessages();
        if(!empty($messages[0])){
            $viewModel->setVariable('message', $messages[0]);
        }

        return $viewModel;
    }

    /** this function called by indexAction to reduce complexity of function */
    protected function authenticate($form, $viewModel)
    {
        $request = $this->getRequest();
           
        $dataform = $form->getData();
        $result = $this->identityManager->login($dataform['username'], $dataform['password']);

        if ($result->isValid()) {
            //authentication success
            $identityRow = $this->identityManager->getAuthService()->getAdapter()->getResultRowObject();
            $this->identityManager->storeIdentity(
                 array('id'          => $identityRow->id,
                        'username'   => $dataform['username'],
                        'ip_address' => $this->getRequest()->getServer('REMOTE_ADDR'),
                        'user_agent'    => $request->getServer('HTTP_USER_AGENT'))
            );

            return $this->redirect()->toRoute('home');
        } else {
             $this->flashMessenger()->addMessage('El usuario y/o contraseña es incorrecta.');
             $this->redirect()->toUrl('/');
        }
           
        
    }

    public function logoutAction()
    {
        $this->identityManager->logout();

        return $this->redirect()->toRoute('auth');
    }
}
