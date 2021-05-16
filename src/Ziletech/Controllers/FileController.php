<?php

namespace Ziletech\Controllers;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Stream;
use Ziletech\Controllers\BaseController;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\EntityFactory;

class FileController extends BaseController {

    /**
     * UserController constructor.
     *
     * @param ContainerInterface $container
     *
     * @internal param $auth
     */
    public function __construct(ContainerInterface $container) {
        define('CHUNK_SIZE', 1024 * 1024); // Size (in bytes) of tiles chunk
        parent::__construct($container);
    }

    public function download(Request $request, Response $response, array $args) {
        $id = $request->getAttribute("id");
        $fileDAO = $this->daoFactory->getFileDAO();
        $file = $fileDAO->findById($id);
        if (!isset($file)) {
            return $response->withJson(["errors" => "File not found."], 404);
        } else {
            $fileName = $file->getName();
            // create a Stream object, to stream your file to the client
            $body = new Stream($file->getData());
            return $response
                ->withHeader('Content-Type', $file->getContentType())
                ->withHeader(
                    'Content-Disposition', "attachment; filename=" . basename($fileName)
                )
                ->withHeader('Content-Transfer-Encoding', 'Binary')
                ->withHeader('Content-Description', 'File Transfer')
                ->withHeader('Pragma', 'public')
                ->withHeader('Expires', '0')
                ->withHeader('Cache-Control', 'must-revalidate')
                ->withBody($body)
                ->withHeader('Content-Length', "{$file->getSize()}");
        }
    }

    public function delete(Request $request, Response $response, array $args) {
        $id = $request->getAttribute("id");
        $fileDAO = $this->daoFactory->getFileDAO();
        $file = $fileDAO->findById($id);
        $fileDAO->remove($file);
        return $response->withSuccess("Deleted successfully");
    }

    public function upload(Request $request, Response $response, array $args) {
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedfile = $uploadedFiles["fileKey"];
        $fileDAO = $this->daoFactory->getFileDAO();
        $content = $uploadedfile->getStream(); //->read($uploadedfile["size"]);
        $file = EntityFactory::getFile();
        $file->setContentType($uploadedfile->getClientMediaType());
        $file->setName($uploadedfile->getClientFilename());
        $file->setData($content);
        $file->setSize($uploadedfile->getSize());
        $fileDAO->save($file);
        $fileDTO = DTOFactory::getFileDTO();
        $fileDTO->copyFromDomain($file);
        return $response->withJson($fileDTO);
    }

}
