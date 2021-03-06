<?php

class QuestaoController extends \HXPHP\System\Controller {

    public function __construct($configs) {
        parent::__construct($configs);
        $this->load('Storage\Session');
        $this->load('Services\Auth', $configs->auth->after_login, $configs->auth->after_logout, true
        );

        $this->view->setTitle('SIGMA - Questões');
        $this->auth->redirectCheck(false);


        $role_id = User::find($this->auth->getUserId());

        if (!empty($role_id->role_id)) {
            if ($role_id->role_id != 3) {
                $this->view->setHeader('header_admin');
            } else {
                $this->view->setHeader('header_aluno');
            }
        }
    }

    public function indexAction() {
        $this->view->setFile('index');
    }

    public function definirAtividadeAction() {
        $this->view->setFile('index');
        $this->view->setVars([
            'activity' => Activity::all()
        ]);
    }

    public function responderAvaliacaoAction($contador = null) {

        $this->view->setFile('avaliacao');

        if (is_null($contador)) {
            $contador = 1;
        }

        $post = $this->request->post();

        if (!empty($post)) {
            $this->session->set('activity_id', $post['activity_id']);
            $this->view->setVars([
                'activity' => $post,
                'question' => Question::All(),
                'contador' => $contador
            ]);
        } else {
            $this->load('Helpers\Alert', array(
                'danger',
                'Nenhuma avaliação definida. Por favor tente novamente!<br>
          <h6>Clique em fazer atividade no menu ao lado e defina uma avaliação....</h6>'
            ));
        }
    }

    public function gravaRespostaAvaliacaoAction($contador = null) {

        $this->view->setFile('avaliacao');

        $post = $this->request->post();

        $activity = [
            'activity_id' => $this->session->get('activity_id')
        ];

        if (is_null($contador)) {
            $contador = 1;
        } else {
            $contador++;
        }

        if (!empty($post)) {
            $this->view->setVars([
                'activity' => $activity,
                'question' => Question::All(),
                'contador' => $contador
            ]);

            $alternativa = substr($post['alternative'], 0, 1);
            $questao_id = substr($post['alternative'], 2);

            $post = [
                'user_id' => $this->auth->getUserId(),
                'question_id' => $questao_id,
                'alternative' => $alternativa,
                'number' => ($contador - 1)
            ];

            $gravacao = Answers::salvarResposta($post);

            if ($gravacao->status === false) {
                $this->view->setFile('avaliacao');
                $this->load('Helpers\Alert', array(
                    'danger',
                    'Ops! Não conseguimos salvar sua resposta pois:',
                    $gravacao->errors
                ));
            }
            $this->view->setFile('avaliacao');
        }
    }

    public function visualizarAtividadeAction($activity_id = null) {
        $this->view->setFile('listarAtividades');
        $this->view->setVars([
            'activity' => Activity::all()
        ]);

        $activity_id = $this->session->get('activity');
    }

    public function visualizarHistoricoAction($activity_id = null) {

        $post = $this->request->post();
        $this->view->setFile('historico');

        $this->view->setVars([
            'tipo' => $post
        ]);

        if (!is_null($activity_id)) {
            $this->session->set('id_atividade', $activity_id);
        }
        $id_atividade = $this->session->get('id_atividade');

        $acerto = Answers::find_by_sql("SELECT COUNT(answers.id)as acertos from answers
                                        join questions on questions.id = answers.question_id 
                                        join users on users.id = answers.user_id
                                        WHERE(questions.activity_id = ? and answers.alternative 
                                        = questions.answer AND users.id = ?)", array($id_atividade, $this->auth->getUserId()));
        
        $total = Answers::find_by_sql("SELECT COUNT(questions.id)as total from questions
                                      WHERE(questions.activity_id = ?)", array($id_atividade));
        
        $erros = ((int)$total[0]->total - (int)$acerto[0]->acertos);
 
        $subject = Activity::find($id_atividade);
        
        $this->view->setVars([
            'tipo' => $post,
            'acertos' => $acerto[0]->acertos,
            'erros' => $erros,
            'assunto' => $subject
        ]);
    }

    public function destruirSessionAction() {
        $this->session->clear('activity_id');

        $this->view->setPath('home');
        $this->view->setFile('index');
    }

}
