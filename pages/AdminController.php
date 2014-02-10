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
        $tag = $this->app['request']->get('tag');


        if (!empty($title) && !empty($article)) {
            $sql = "INSERT INTO articles (
                id ,
                title ,
                body ,
                tag 
            )
            VALUES (
                NULL ,
                :title,
                :body,
                :tag
            )";

            $arguments = array(
                ':title' => $title,
                ':body' => $article,
                ':tag' => $tag,
            );

            $this->app['sql']->prepareExec($sql, $arguments);
        }





        $id_articles = $this->app['request']->get('id_articles');
        $id_tags = $this->app['request']->get('id_tags');


        if (!empty($tag)) {
            $sql = "INSERT INTO articles_tags(
                id ,
                id_articles,
                id_tags
            )
            VALUES (
                NULL ,
                :id_articles,
                :id_tags              
            )";

            $arguments = array(
                ':id_articles' => $id_articles,
                ':id_tags' => $id_tags,
                );

            $this->app['sql']->prepareExec($sql, $arguments);
        }

        return $this->getArticle();
    }

}
