<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

class SocialSciencesExamSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$exam = Exam::create([
			'title' => 'Examen sociales 2',
			'duration_minutes' => 23,
		]);

		if (! $exam) {
			return;
		}

		$questions = [
			[
				'text' => '¿Qué caracteriza al Impresionismo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'El uso de la luz y el color para capturar momentos fugaces', 'is_correct' => true],
					['text' => 'El uso de líneas precisas y colores oscuros', 'is_correct' => false],
					['text' => 'La representación de escenas mitológicas', 'is_correct' => false],
					['text' => 'La ausencia de perspectiva', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Cuál es una característica principal del Postimpresionismo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Mayor énfasis en la emoción y el simbolismo', 'is_correct' => true],
					['text' => 'Enfoque en los retratos realistas', 'is_correct' => false],
					['text' => 'Uso de colores monocromáticos', 'is_correct' => false],
					['text' => 'Estilo completamente abstracto', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué movimiento artístico se caracteriza por la distorsión de las formas y el uso de colores intensos?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Expresionismo', 'is_correct' => true],
					['text' => 'Surrealismo', 'is_correct' => false],
					['text' => 'Realismo', 'is_correct' => false],
					['text' => 'Pop Art', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Quién es uno de los artistas más representativos del Expresionismo y autor de "El grito"?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Edvard Munch', 'is_correct' => true],
					['text' => 'Egon Schiele', 'is_correct' => false],
					['text' => 'Wassily Kandinsky', 'is_correct' => false],
					['text' => 'Franz Marc', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué caracteriza al Cubismo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'El uso de formas geométricas y la fragmentación de las figuras', 'is_correct' => true],
					['text' => 'El enfoque en la luz y el color', 'is_correct' => false],
					['text' => 'La representación de la realidad cotidiana', 'is_correct' => false],
					['text' => 'La influencia de la cultura pop', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué artista es cofundador del Cubismo junto a Georges Braque?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Pablo Picasso', 'is_correct' => true],
					['text' => 'Henri Matisse', 'is_correct' => false],
					['text' => 'Juan Gris', 'is_correct' => false],
					['text' => 'Paul Klee', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué movimiento artístico representa la transición del arte moderno al contemporáneo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Pop Art', 'is_correct' => true],
					['text' => 'Postimpresionismo', 'is_correct' => false],
					['text' => 'Cubismo', 'is_correct' => false],
					['text' => 'Surrealismo', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Quién pintó "La creación de Adán"?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Miguel Ángel', 'is_correct' => true],
					['text' => 'Leonardo da Vinci', 'is_correct' => false],
					['text' => 'Rafael', 'is_correct' => false],
					['text' => 'Tiziano', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Cuál de las siguientes es una obra característica del Barroco?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => '"Las Meninas"', 'is_correct' => true],
					['text' => '"La última cena"', 'is_correct' => false],
					['text' => '"La noche estrellada"', 'is_correct' => false],
					['text' => '"El grito"', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué define al movimiento Barroco?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Exageración y dramatismo', 'is_correct' => true],
					['text' => 'Simplicidad y equilibrio', 'is_correct' => false],
					['text' => 'Colores pastel y paisajes idílicos', 'is_correct' => false],
					['text' => 'Geometría y abstracción', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué busca representar el Realismo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'La realidad tal como es, sin idealización', 'is_correct' => true],
					['text' => 'Los sueños y el subconsciente', 'is_correct' => false],
					['text' => 'Formas geométricas y abstractas', 'is_correct' => false],
					['text' => 'Paisajes llenos de fantasía', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué define al Surrealismo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Exploración de los sueños y el subconsciente', 'is_correct' => true],
					['text' => 'Uso de formas geométricas', 'is_correct' => false],
					['text' => 'Representación de paisajes rurales', 'is_correct' => false],
					['text' => 'Enfoque en la luz y el color', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué década marca el surgimiento del Pop Art?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Década de 1950', 'is_correct' => true],
					['text' => 'Década de 1920', 'is_correct' => false],
					['text' => 'Década de 1960', 'is_correct' => false],
					['text' => 'Década de 1970', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Quién es el autor de "La noche estrellada"?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Vincent van Gogh', 'is_correct' => true],
					['text' => 'Georges Seurat', 'is_correct' => false],
					['text' => 'Paul Cézanne', 'is_correct' => false],
					['text' => 'Henri Matisse', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué característica distingue al arte renacentista?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Antropocentrismo y estudio de la perspectiva', 'is_correct' => true],
					['text' => 'Enfoque en lo religioso y la emoción', 'is_correct' => false],
					['text' => 'Representación de lo cotidiano con realismo extremo', 'is_correct' => false],
					['text' => 'Uso de imágenes abstractas', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Cuándo se desarrolló el arte barroco?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Siglos XVII y XVIII', 'is_correct' => true],
					['text' => 'Siglo XV', 'is_correct' => false],
					['text' => 'Siglo XIX', 'is_correct' => false],
					['text' => 'Siglo XX', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué artista es representativo del barroco?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Caravaggio', 'is_correct' => true],
					['text' => 'Miguel Ángel', 'is_correct' => false],
					['text' => 'Claude Monet', 'is_correct' => false],
					['text' => 'Andy Warhol', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué movimiento surge como respuesta a los excesos del barroco?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Realismo', 'is_correct' => true],
					['text' => 'Surrealismo', 'is_correct' => false],
					['text' => 'Cubismo', 'is_correct' => false],
					['text' => 'Pop Art', 'is_correct' => false],
				],
			],
			[
				'text' => '¿En qué siglo se desarrolla principalmente el Realismo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Siglo XIX', 'is_correct' => true],
					['text' => 'Siglo XVII', 'is_correct' => false],
					['text' => 'Siglo XX', 'is_correct' => false],
					['text' => 'Siglo XV', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué movimiento artístico distorsiona las formas para expresar emociones intensas?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Expresionismo', 'is_correct' => true],
					['text' => 'Realismo', 'is_correct' => false],
					['text' => 'Cubismo', 'is_correct' => false],
					['text' => 'Impresionismo', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué define al Cubismo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Uso de formas geométricas para descomponer y reconstruir imágenes', 'is_correct' => true],
					['text' => 'Escenas de la vida cotidiana y la naturaleza', 'is_correct' => false],
					['text' => 'Enfoque en la luz y el color', 'is_correct' => false],
					['text' => 'Inspiración en los sueños y el subconsciente', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué caracteriza al Postimpresionismo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Mayor enfoque en la emoción y el simbolismo', 'is_correct' => true],
					['text' => 'Uso de líneas geométricas y formas abstractas', 'is_correct' => false],
					['text' => 'Representación exacta de la realidad', 'is_correct' => false],
					['text' => 'Influencia de la religión en el arte', 'is_correct' => false],
				],
			],
			[
				'text' => '¿Qué define al Impresionismo?',
				'theme' => 'movimientos artísticos',
				'answers' => [
					['text' => 'Captura de la luz y los momentos fugaces', 'is_correct' => true],
					['text' => 'Uso de colores planos y monocromáticos', 'is_correct' => false],
					['text' => 'Representación de escenas históricas', 'is_correct' => false],
					['text' => 'Formas distorsionadas y simbólicas', 'is_correct' => false],
				],
			],
		];

		foreach ($questions as $index => $questionData) {
			$question = $exam->questions()->create([
				'text' => $questionData['text'],
				'theme' => $questionData['theme'],
				'order' => $index + 1,
			]);

			$question->answers()->createMany($questionData['answers']);
		}
	}
}

