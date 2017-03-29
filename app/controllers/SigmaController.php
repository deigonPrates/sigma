<?php

class SigmaController extends \HXPHP\System\Controller {

    public function __construct($configs) {
        parent::__construct($configs);

        $this->load('Services\Auth', $configs->auth->after_login, $configs->auth->after_logout, true
        );
        $this->view->setTitle('SIGMA - Gerenciamento');
        $this->auth->redirectCheck(false);
        $this->view->setFile('listar');

        $this->load('Storage\Session');

        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            $this->view->setHeader('header_admin');
        } else {
            $this->view->setHeader('header_aluno');
        }
    }

    /*
     * function para verificar o nivel de acesso do usuario
     * caso seja admim  return true caso não return false
     */

    public function checkNivel($user_id) {
        $role_id = User::find($this->auth->getUserId());

        if (!empty($role_id->role_id)) {
            if ($role_id->role_id != 3) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function listarAtividadeAction($user_id = null) {

        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            $this->view->setTitle('SIGMA - Atividades');
            $this->view->setFile('listarAtividades');
            $this->view->setVars([
                'activity' => Activity::all()
            ]);
        }
    }

    public function listarUsuariosAction($user_id = null) {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            $this->view->setTitle('SIGMA - Usuários');
            $this->view->setFile('listar');
            $this->view->setVars([
                'users' => User::all()
            ]);
        }
    }

    public function bloquearAction($user_id = null) {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            if (is_numeric($user_id)) {
                $user = User::find_by_id($user_id);
                if (!is_null($user)) {
                    $user->status = 0;
                    $user->save(false);
                    $this->view->setVar('users', User::all());
                }
            }
        }
    }

    public function desbloquearAction($user_id = null) {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            if (is_numeric($user_id)) {
                $user = User::find_by_id($user_id);
                if (!is_null($user)) {
                    $user->status = 1;
                    $user->save(false);
                    $this->view->setVar('users', User::all());
                }
            }
        }
    }

    public function bloquearAtividadeAction($activity_id = null) {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            if (is_numeric($activity_id)) {
                $activity = Activity::find_by_id($activity_id);
                if (!is_null($activity)) {
                    $activity->status = 0;
                    $activity->save(false);
                    $this->view->setVar('activity', Activity::all());
                    $this->view->setFile('listarAtividades');
                }
            }
        }
    }

    public function desbloquearAtividadeAction($activity_id = null) {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            if (is_numeric($activity_id)) {
                $activity = Activity::find_by_id($activity_id);
                if (!is_null($activity)) {
                    $activity->status = 1;
                    $activity->save(false);
                    $this->view->setVar('activity', Activity::all());
                    $this->view->setFile('listarAtividades');
                }
            }
        }
    }

    public function excluirAction($user_id = null) {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            if (is_numeric($user_id)) {
                $user = User::find_by_id($user_id);
                if (!is_null($user)) {
                    $user->delete();
                    $this->view->setVar('users', User::all());
                }
            }
        }
    }

    /**
     * Mostra todas as atividade na table da view
     */
    public function RDAtividadeAction() {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            $this->view->setFile('RDAtividade');
            $this->view->setVars([
                'activity' => Activity::all()
            ]);
        }
    }

    /*     * *
     * Mostra todos os alunos na table da view
     */

    public function RDAlunoAction() {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            $this->view->setFile('RDAluno');
            $this->view->setVars([
                'users' => User::all()
            ]);
        }
    }

    public function listarTurmaAction() {
        $this->view->setVars([
            'room' => Room::all()
        ]);
        $this->view->setFile('listarTurma');
    }

    public function bloquearTurmaAction($room_id = null) {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            if (is_numeric($room_id)) {
                $room = Room::find_by_id($room_id);
                if (!is_null($room)) {
                    $room->status = 0;
                    $room->save(false);
                    $this->view->setVar('room', Room::all());
                    $this->view->setFile('listarTurma');
                }
            }
        }
    }

    public function desbloquearTurmaAction($room_id = null) {
        $check = $this->checkNivel($this->auth->getUserId());

        if ($check === true) {
            if (is_numeric($room_id)) {
                $room = Room::find_by_id($room_id);
                if (!is_null($room)) {
                    $room->status = 1;
                    $room->save(false);
                    $this->view->setVar('room', Room::all());
                    $this->view->setFile('listarTurma');
                }
            }
        }
    }

    public function visualizarRDAtividadeAction($activity_id = null) {
        $post = $this->request->post();
        $this->view->setHeader('header_sigma');
        $this->view->setFile('visualizarRDAtividade');

        if (!is_null($activity_id)) {
            $this->session->set('activity_id', $activity_id);
        } else {
            $activity_id = $this->session->get('activity_id');
        }
        $subject = Activity::find($activity_id);

        #pegar o id dos alunos q fizeram a prova
        $user = User::find_by_sql("select DISTINCT users.id from users
                                    join answers on answers.user_id = users.id
                                    join questions on questions.id = answers.question_id
                                     WHERE(questions.activity_id = 1)", array($activity_id));

        $user_id = array();
        $notas = array();

        #total de usuario
        foreach ($user as $key) {
            $user_id[] = $key->id;
        }
        $notas_user = array();

        #notas do usuarios
        for ($i = 0; $i < count($user_id); $i++) {
            $nota = User::find_by_sql("SELECT SUM(questions.value)as nota FROM questions
                                           join answers on answers.question_id = questions.id
                                           WHERE (answers.alternative = questions.answer AND 
                                           questions.activity_id = ? and answers.user_id = ?)", array($activity_id, $user[$i]->id));

            foreach ($nota as $key) {
                if (!is_null(($key->nota))) {
                    $notas[] = (int) $key->nota;
                } else {
                    $notas[] = 0;
                }
            }
        }

        for ($i = 0; $i < count($user_id); $i++) {
            $indice = $user_id[$i];
            $valor = $notas[$i];
            array_push($notas_user, [$indice => $valor]);
        }

        #total de questoes
        $total_questoes = Question::find_by_sql("select COUNT(questions.value)as total from questions
                                                    WHERE(questions.activity_id = ?)", array($activity_id));
        $total_questoes = (int) $total_questoes[0]->total;

        #valor base
        $base = Question::find_by_sql("select sum(questions.value)/count(questions.value) as media FROM questions
                                          WHERE(questions.activity_id = ?)", array($activity_id));
        $base = (int) $base[0]->media;

        for ($i = 0; $i < count($user_id); $i++) {

            foreach ($notas_user[$i] as $key => $value) {
                $aprovados = (count($value > $base));
                $reprovados = (count($value < $base));
            }
        }

        #completo
        $questoes_acertos = array();

        #pega todos os alunos q fizeram a prova
        for ($i = 0; $i < count($user_id); $i++) {
            #pega as questoes
            for ($j = 1; $j <= $total_questoes; $j++) {
                $questoes_acertos[] = Question::find_by_sql("SELECT count(questions.id) as total from questions 
                                                                join answers on answers.question_id = questions.id 
                                                                join users on users.id = answers.user_id 
                                                                where(answers.alternative = questions.answer and 
                                                                users.id = ? and questions.number = ? and
                                                                questions.activity_id = ?)"
                                , array($user_id[$i], $j, $activity_id)
                );
            }
        }
        #pega todos os alunos q fizeram a prova
        for ($i = 0; $i < count($user_id); $i++) {
            #pega as questoes
            for ($j = 1; $j <= $total_questoes; $j++) {
                $questoes_erros[] = Question::find_by_sql("SELECT distinct count(questions.id) as total from questions 
                                                           join answers on answers.question_id = questions.id 
                                                           join users on users.id = answers.user_id 
                                                           where(answers.alternative != questions.answer and 
                                                           questions.number = ?  and questions.activity_id = ?)"
                                , array($j, $activity_id));
            }
        }
        $acertos = $this->somarQuestoes($questoes_acertos, $total_questoes);
        $erros = $this->somarQuestoes($questoes_erros, $total_questoes);

        $this->view->setVars([
            'tipo' => $post,
            'aprovados' => $aprovados,
            'reprovados' => $reprovados,
            'acertos' => $acertos,
            'erros' => $erros,
            'total' => $total_questoes,
            'assunto' => $subject
        ]);
    }

    /**
     * @author Deigon Prates <deigonprates@gmail.com> 
     * @example informando um array com 8 elementos e o total de questões são 4 ele soma o 1 com o 5 o 2 e assim por diante
     * e retorna um array contento a soma 
     * @param type $questoes array de array contendo todas as questoes 
     * @param type $total_questoes total de questoes da prova
     * @return type Array
     */
    private function somarQuestoes($questoes, $total_questoes) {
        $limpa = array();
        foreach ($questoes as $key => $value) {
            $limpa[] = (int) $value[0]->total;
        }
        $questoes_final = array();
        $aux = 1;

        #somar a quantidade de acerto de cada questãos
        for ($i = 0; $i < count($limpa); $i++) {

            if ($i < $total_questoes) {
                $questoes_final[$i] = $limpa[$i];
            } else {
                $questoes_final[$aux] = ($limpa[$i] + $questoes_final[$aux] );
                $aux++;
            }
            if ($aux == $total_questoes) {
                $aux = 1;
            }
        }

        return $questoes_final;
    }

    public function visualizarRDAlunoAction($user_id = null) {
        $post = $this->request->post();
        $this->view->setHeader('header_sigma');
        $this->view->setFile('visualizarRDAluno');


        if (!is_null($user_id)) {
            $this->session->set('$user_id', $user_id);
        } else {
            $user_id = $this->session->get('$user_id');
        }

        $activity_all = Activity::find('all');
        $activity_id = array();

        foreach ($activity_all as $value) {
            $activity_id[] = $value->id;
        }

        #pega o total de acerto de cada prova
        for ($i = 0; $i < count($activity_id); $i++) {
            $query_acertos = [$activity_id[$i] => Answers::find_by_sql("SELECT COUNT(answers.id)as acertos from answers
                                        join questions on questions.id = answers.question_id 
                                        join users on users.id = answers.user_id
                                        WHERE(questions.activity_id = ? and answers.alternative 
                                        = questions.answer AND users.id = ?)", array($activity_id[$i], $user_id))];
        }

        #pegar o total de questoes de cada prova 
        for ($i = 0; $i < count($activity_id); $i++) {
            $query_total_questoes = [$activity_id[$i] => Question::find_by_sql("SELECT COUNT(questions.id)as total from questions
                                                     where(questions.activity_id = ?)", array($activity_id[$i]))];
        }

        for ($i = 0; $i <= count($query_acertos); $i++) {
            if (!empty($query_acertos[$i])) {
                $acertos = [$i => $query_acertos[$i][0]->acertos];
            }
        }

        for ($i = 0; $i <= count($query_total_questoes); $i++) {
            if (!empty($query_total_questoes[$i])) {
                $total = [$i => $query_total_questoes[$i][0]->total];
            }
        }
        for ($i = 0; $i <= count($acertos); $i++) {
            if (!empty($acertos[$i])) {
                $erros[$i] = $total[$i] - $acertos[$i];
            }
        }
        var_dump($erros);
    }

}
