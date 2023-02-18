<?php

namespace WPFP\App\Controllers;

use WPFP\App\Helpers\Blade_view;
use WPFP\Boot\System\Controller;
use WPFP\App\Models\M_post;

class Wpf_dashboard extends Controller
{

    public function __construct()
    {
        // Add Something
        $this->model('m_post');
    }

    public function index()
    {
        var_dump(date("Y-m-d H:m:s"));

        // create
        M_post::create([
            'user_login'    => 'initflex',
            'user_pass'     => 'abcde',
            'user_nicename' => 'initflex',
            'user_email '   => 'initflex22@gmail.com',
            'user_registered'  => current_time('mysql')
        ]);

        $data = M_post::all();

        foreach ($data as $key => $value){
            echo $value->user_login .'<br/>';
        }

        $dataUsers = [
            'name'      =>  wp_get_current_user()->display_name
        ];

        $connection = new \PDO('mysql:host=localhost;dbname=wpframe_wp6;charset=utf8', 'root', '');

        // create a new mysql query builder
        $h = new \ClanCats\Hydrahon\Builder('mysql', function($query, $queryString, $queryParameters) use($connection)
        {
            $statement = $connection->prepare($queryString);
            $statement->execute($queryParameters);

            // when the query is fetchable return all results and let hydrahon do the rest
            // (there's no results to be fetched for an update-query for example)
            if ($query instanceof \ClanCats\Hydrahon\Query\Sql\FetchableInterface)
            {
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            // when the query is a instance of a insert return the last inserted id  
            elseif($query instanceof \ClanCats\Hydrahon\Query\Sql\Insert)
            {
                return $connection->lastInsertId();
            }
            // when the query is not a instance of insert or fetchable then
            // return the number os rows affected
            else 
            {
                return $statement->rowCount();
            }	
        });

        $people = $h->table('wp_users');
        $data = $people->select()->get();
        //var_dump($data);

        Blade_view::render('default_wpframe/index', $dataUsers);
    }
}