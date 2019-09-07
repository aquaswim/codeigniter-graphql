<?php defined('BASEPATH') OR exit('No direct script access allowed');

use GraphQL\Type\Definition\Type;

/**
 * Created by PhpStorm.
 * User: Bayu Setiawan (bayu.tuodeschawk@gmail.com)
 * Date: 05/09/2019
 * Time: 19:22
 */
class Graphapi extends Graphql_Controller
{
	public function init()
	{
		return [
			'echo'=>[
				'type'=> Type::string(),
				'args'=> [
					'message' => Type::nonNull(Type::string()),
				],
				'resolve'=> function($root, $args){
					return $root['prefix'] . $args['message'];
				}
			],
			'randomint'=>[
				'type'=>Type::int(),
				'args'=>[
					'min'	=> [
						'type'=>Type::int(),
						'defaultValue'=> 0
					],
					'max'	=> [
						'type'=>Type::int(),
						'defaultValue'=>10
					],
				],
				'resolve'=>function($root, $args){
					return rand(
						$args['min'],
						$args['max']
					);
				}
			]
		];
	}

	public function rootValue()
	{
		return ['prefix' => 'You said: '];
	}
}
