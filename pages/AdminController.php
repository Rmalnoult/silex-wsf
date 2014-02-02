<?php

use Blog\Controller;

Class AdminController extends Controller
{

    /**
     * get Article action :
     * Affiche la page /admin
     *
     * @return string  html rendu par twig
     */
    public function getArticle()
    {
        $data = array();

        if ($this->isLogged() === false) {
            return $this->app->redirect(
                $this->app['url_generator']->generate('home')
            );
        }

        return $this->app['twig']->render('admin.twig', $data);
    }


    /**
     * [postArticle description]
     * @return [type] [description]
     */
    public function postArticle()
    {

        $title = $this->app['request']->get('title');
        $article = $this->app['request']->get('article');
        $tag1 = $this->app['request']->get('tag1');
        $tag2 = $this->app['request']->get('tag2');


        if (!empty($title) && !empty($article)) {
            $sql = "INSERT INTO articles (
                id ,
                title ,
                body,
                tag1,
                tag2
            )
            VALUES (
                NULL ,
                :title,
                :body,
                :tag1,
                :tag2
            )";

            $arguments = array(
                ':title' => $title,
                ':body' => $article,
                ':tag1' => $tag1,
                'tag2' => $tag2
            );

            $this->app['sql']->prepareExec($sql, $arguments);
        }

        return $this->getArticle();
    }

}
