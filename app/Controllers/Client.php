<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use Codeigniter\HTTP\Response;
use Codeigniter\HTTP\ResponseInterface;
use Exception;


class Client extends BaseController
{
    public function index()
    {
        $model = new ClientModel();
        return $this->getResponse(
            [
                'message' => 'Client sukses terhubung',
                'clients' => $model->findAll()
            ]
            );
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[client.email]',
            'retainer_fee' => 'required|max_length[255]'
        ];

        $input = $this->getRequestInput($this->request);
        if (!$this->validateRequest($input, $rules)) {
            return $this
                    ->getResponse(
                        $this->validator->getErrors(),
                        ResponseInterface::HTTP_BAD_REQUEST
                    );
        }

        $clientEmail = $input['email'];

        $model = new ClientModel();
        $model->save($input);

        $client = $model->where('email', $clientEmail)->first();

        return $this->getResponse(
            [
                'message' => 'Berhasil ditambahkan',
                'client' => $client
            ]
        );
    }

    public function show($id)
    {
        try {
            $model = new ClientModel();
            $client = $model->findClientById($id);

            return $this->getResponse(
                [
                    'message' => 'Client berhasil ditampilkan',
                    'client' => $client
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Tidak ditemukan dengan ID tersebut',
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function update($id)
    {
        try {
            $model = new ClientModel();
            $model->findClientById($id);

            $input = $this->getRequestInput($this->request);

            $model->update($id, $input);
            $client = $model->findClientById($id);

            return $this->getResponse(
                [
                    'message' => 'Client berhasi diupdate',
                    'client' => $client
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => $e->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function destroy($id)
    {
        try {
            $model = new ClientModel();
            $client = $model->findClientById($id);
            $model->delete($client);

            return $this->getResponse(
                        [
                            'message' => 'Client berhasil dihapus'
                        ]
                    );

        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => $e->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }
}
