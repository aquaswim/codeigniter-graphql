<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Bayu Setiawan (bayu.tuodeschawk@gmail.com)
 * Date: 05/09/2019
 * Time: 19:26
 */
abstract class Graphql_Controller extends MY_Controller
{
	public abstract function init();

	public function rootValue()
	{
		return [];
	}

	public final function index()
	{
		try{
			$queryType = new \GraphQL\Type\Definition\ObjectType([
				'name'	=> 'Query',
				'fields'=> $this->init(),
			]);
			$schema = new GraphQL\Type\Schema([
				'query'=> $queryType
			]);
			$rawInput = $this->input->raw_input_stream;
			$input = json_decode($rawInput, true);
			if (!isset($input['query']))
			{
				throw new Exception('Invalid request.',-1);
			}
			$query = $input['query'];
			$variableValues = isset($input['variables']) ? $input['variables'] : null;
			$result = GraphQL\GraphQL::executeQuery($schema, $query, $this->rootValue(), NULL, $variableValues);
			$output = $result->jsonSerialize();
		} catch (Exception $e) {
			$output = [
				'errors' => [
					[
						'message' 	=> $e->getMessage(),
						'code'		=> $e->getCode()
					]
				]
			];
		} finally {
			$this
				->output
				->set_content_type('json')
				->set_output(json_encode($output));
		}
	}
}
