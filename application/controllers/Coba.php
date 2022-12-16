<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coba extends CI_Controller
{
	public function index()
	{
		$this->load->view('index');
	}

	public function ajaxSubmit()
	{
		$this->load->library('form_validation');

		$response = [
			'code'		=> 500,
			'message'	=> [
				'title'	=> 'Error',
				'body'	=> 'Gagal menyimpan'
			]
		];

		$config = array(
			array(
				'field' => 'first_name',
				'label' => 'First Name',
				'rules' => [
					'required',
					'min_length[3]',
					'max_length[20]',
					'alpha'
				]
			),
			array(
				'field' => 'last_name',
				'label' => 'Last Name',
				'rules' => [
					'required',
					'min_length[3]',
					'max_length[20]',
					'alpha'
				]
			),
			array(
				'field' => 'username',
				'label' => 'User Name',
				'rules' => [
					'required',
					'min_length[3]',
					'max_length[20]',
					'alpha'
				]
			),
			array(
				'field' => 'city',
				'label' => 'City',
				'rules' => [
					'required',
					'min_length[3]',
					'max_length[20]',
					'alpha'
				]
			),
			array(
				'field' => 'state',
				'label' => 'State',
				'rules' => [
					'required',
				]
			),
			array(
				'field' => 'zip',
				'label' => 'Zip',
				'rules' => [
					'required',
					'exact_length[5]',
					'numeric'
				]
			),
			array(
				'field' => 'agreement',
				'label' => 'Agreement',
				'rules' => [
					'required',
				]
			),
		);

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			$response['code'] = 400;
			$response['message'] = [
				'title'	=> 'Peringatan',
				'body'	=> 'Terdapat form yang belum sesuai'
			];
			$response['errors'] = $errors;
		} else {
			// proses data

			$response['code'] = 200;
			$response['message'] = [
				'title'	=> 'Sukses',
				'body'	=> 'Berhasil menyimpan data'
			];
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header($response['code'])
			->set_output(json_encode($response));
	}
}
