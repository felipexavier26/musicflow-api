<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Musica;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MusicaController extends Controller
{


    public function index()
    {
        try {
            $musicas = Musica::orderBy('id', 'DESC')->paginate(5);

            return response()->json([
                'musicas' => [
                    'data' => $musicas->items(),
                    'current_page' => $musicas->currentPage(),
                    'last_page' => $musicas->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erro ao carregar músicas",
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function extractVideoId($url)
    {
        $patterns = [
            '/youtube\.com\/watch\?v=([^&]+)/',
            '/youtu\.be\/([^?]+)/',
            '/youtube\.com\/embed\/([^?]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    public function getVideoInfo($videoId)
    {
        $url = "https://www.youtube.com/watch?v=" . $videoId;
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception("Erro ao acessar o YouTube: " . curl_error($ch));
        }

        curl_close($ch);

        if (!preg_match('/<title>(.+?) - YouTube<\/title>/', $response, $titleMatches)) {
            throw new Exception("Não foi possível encontrar o título do vídeo");
        }

        $title = html_entity_decode($titleMatches[1], ENT_QUOTES);

        if (preg_match('/"viewCount":\s*"(\d+)"/', $response, $viewMatches)) {
            $views = (int)$viewMatches[1];
        } else {
            $views = 0;
        }

        return [
            'titulo' => $title,
            'visualizacoes' => $views,
            'youtube_id' => $videoId,
            'thumb' => 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg',
        ];
    }

    public function salvaMusica($videoInfo)
    {
        Musica::create([
            'titulo' => $videoInfo['titulo'],
            'youtube_id' => $videoInfo['youtube_id'],
            'visualizacoes' => $videoInfo['visualizacoes'],
            'thumb' => $videoInfo['thumb'],
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'url' => 'required|url',
            ]);

            $videoId = $this->extractVideoId($validatedData['url']);
            if (!$videoId) {
                return response()->json([
                    "status" => false,
                    'message' => 'URL do YouTube inválida'
                ], 400);
            }

            $videoInfo = $this->getVideoInfo($videoId);

            $this->salvaMusica($videoInfo);

            DB::commit();

            return response()->json([
                "status" => true,
                'message' => 'Música sugerida com sucesso!',
                'musica' => $videoInfo,
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                'message' => "Erro ao sugerir a música",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $musica = Musica::findOrFail($id);
            return response()->json([
                'status' => true,
                'musica' => $musica
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Erro ao buscar a música",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $musica = Musica::findOrFail($id);

            $validatedData = $request->validate([
                'url' => 'required|url',
            ]);

            $videoId = $this->extractVideoId($validatedData['url']);
            if (!$videoId) {
                return response()->json([
                    "status" => false,
                    'message' => 'URL do YouTube inválida',
                ], 400);
            }

            $videoInfo = $this->getVideoInfo($videoId);

            $musica->update([
                'url' => $validatedData['url'],
                'titulo' => $videoInfo['titulo'],
                'youtube_id' => $videoInfo['youtube_id'],
                'visualizacoes' => $videoInfo['visualizacoes'],
                'thumb' => $videoInfo['thumb'],
            ]);

            DB::commit();

            return response()->json([
                "status" => true,
                'message' => "Música atualizada com sucesso!",
                'musica' => $musica,
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                'message' => "Erro ao atualizar a música",
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $musica = Musica::findOrFail($id);

            $musica->delete();

            return response()->json([
                "status" => true,
                'message' => "Música apagada com sucesso!",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Erro ao apagar a música",
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}