<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;

class RazonamientoLogicoExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exam = Exam::create([
            'title' => 'Examen de Razonamiento Lógico y Series Numéricas',
            'duration_minutes' => 50,
        ]);

        if (! $exam) {
            return;
        }

        $questions = [
            [
                'text' => 'Célula es a tejido como átomo es a:',
                'answers' => [
                    ['text' => 'Molécula', 'is_correct' => true],
                    ['text' => 'Órgano', 'is_correct' => false],
                    ['text' => 'Materia', 'is_correct' => false],
                    ['text' => 'Energía', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Pulmón es a respirar como corazón es a:',
                'answers' => [
                    ['text' => 'Bombear', 'is_correct' => true],
                    ['text' => 'Sangre', 'is_correct' => false],
                    ['text' => 'Latir', 'is_correct' => false],
                    ['text' => 'Oxigenar', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Microscopio es a pequeño como telescopio es a:',
                'answers' => [
                    ['text' => 'Lejos', 'is_correct' => true],
                    ['text' => 'Grande', 'is_correct' => false],
                    ['text' => 'Espacio', 'is_correct' => false],
                    ['text' => 'Universo', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Veneno es a muerte como medicina es a:',
                'answers' => [
                    ['text' => 'Salud', 'is_correct' => true],
                    ['text' => 'Hospital', 'is_correct' => false],
                    ['text' => 'Cura', 'is_correct' => false],
                    ['text' => 'Enfermedad', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Neuronas es a cerebro como alveolos es a:',
                'answers' => [
                    ['text' => 'Pulmón', 'is_correct' => true],
                    ['text' => 'Sangre', 'is_correct' => false],
                    ['text' => 'Oxígeno', 'is_correct' => false],
                    ['text' => 'Aire', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Capítulo es a libro como párrafo es a:',
                'answers' => [
                    ['text' => 'Texto', 'is_correct' => true],
                    ['text' => 'Hoja', 'is_correct' => false],
                    ['text' => 'Oración', 'is_correct' => false],
                    ['text' => 'Ensayo', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Frío es a congelar como calor es a:',
                'answers' => [
                    ['text' => 'Hervir', 'is_correct' => true],
                    ['text' => 'Temperatura', 'is_correct' => false],
                    ['text' => 'Quemar', 'is_correct' => false],
                    ['text' => 'Sol', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Llave es a puerta como PIN es a:',
                'answers' => [
                    ['text' => 'Acceso', 'is_correct' => true],
                    ['text' => 'Banco', 'is_correct' => false],
                    ['text' => 'Seguridad', 'is_correct' => false],
                    ['text' => 'Sistema', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Semilla es a planta como embrión es a:',
                'answers' => [
                    ['text' => 'Organismo', 'is_correct' => true],
                    ['text' => 'Vida', 'is_correct' => false],
                    ['text' => 'Crecimiento', 'is_correct' => false],
                    ['text' => 'Humano', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Sangre es a cuerpo como savia es a:',
                'answers' => [
                    ['text' => 'Planta', 'is_correct' => true],
                    ['text' => 'Árbol', 'is_correct' => false],
                    ['text' => 'Raíz', 'is_correct' => false],
                    ['text' => 'Hoja', 'is_correct' => false],
                ],
            ],
            [
                'text' => '1, 4, 9, 16, ___',
                'answers' => [
                    ['text' => '25', 'is_correct' => true],
                    ['text' => '20', 'is_correct' => false],
                    ['text' => '36', 'is_correct' => false],
                    ['text' => '30', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Encuentra el número diferente: 1234 – 1234 – 1324 – 1234',
                'answers' => [
                    ['text' => '1324', 'is_correct' => true],
                    ['text' => '1234', 'is_correct' => false],
                    ['text' => '1243', 'is_correct' => false],
                    ['text' => '1342', 'is_correct' => false],
                ],
            ],
            [
                'text' => '2, 6, 7, 21, 22, 66, ___',
                'answers' => [
                    ['text' => '67', 'is_correct' => true],
                    ['text' => '68', 'is_correct' => false],
                    ['text' => '65', 'is_correct' => false],
                    ['text' => '69', 'is_correct' => false],
                ],
            ],
            [
                'text' => '4, 9, 19, 39, 79, ___',
                'answers' => [
                    ['text' => '159', 'is_correct' => true],
                    ['text' => '149', 'is_correct' => false],
                    ['text' => '169', 'is_correct' => false],
                    ['text' => '139', 'is_correct' => false],
                ],
            ],
            [
                'text' => '3, 5, 10, 12, 24, 26, ___',
                'answers' => [
                    ['text' => '52', 'is_correct' => true],
                    ['text' => '50', 'is_correct' => false],
                    ['text' => '48', 'is_correct' => false],
                    ['text' => '54', 'is_correct' => false],
                ],
            ],
            [
                'text' => '¿Cuál palabra no pertenece al grupo? triángulo, cuadrado, círculo, esfera',
                'answers' => [
                    ['text' => 'Esfera', 'is_correct' => true],
                    ['text' => 'Triángulo', 'is_correct' => false],
                    ['text' => 'Cuadrado', 'is_correct' => false],
                    ['text' => 'Círculo', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Encuentra el número que no sigue el patrón: 121, 144, 169, 196, 225, 250',
                'answers' => [
                    ['text' => '250', 'is_correct' => true],
                    ['text' => '225', 'is_correct' => false],
                    ['text' => '196', 'is_correct' => false],
                    ['text' => '169', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Si 5 máquinas hacen 5 piezas en 5 minutos, ¿cuánto tardan 100 máquinas en hacer 100 piezas?',
                'answers' => [
                    ['text' => '5 minutos', 'is_correct' => true],
                    ['text' => '100 minutos', 'is_correct' => false],
                    ['text' => '20 minutos', 'is_correct' => false],
                    ['text' => '1 minuto', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Si una botella cuesta $110 y el líquido cuesta $100 más que la botella, ¿cuánto cuesta la botella?',
                'answers' => [
                    ['text' => '$5', 'is_correct' => true],
                    ['text' => '$10', 'is_correct' => false],
                    ['text' => '$15', 'is_correct' => false],
                    ['text' => '$20', 'is_correct' => false],
                ],
            ],
            [
                'text' => '¿Qué sigue? Z, X, U, Q, ___',
                'answers' => [
                    ['text' => 'L', 'is_correct' => true],
                    ['text' => 'N', 'is_correct' => false],
                    ['text' => 'M', 'is_correct' => false],
                    ['text' => 'K', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Si todos los nefrones son unidades funcionales del riñón y algunas unidades funcionales son estructuras microscópicas, entonces:',
                'answers' => [
                    ['text' => 'Algunos nefrones pueden ser microscópicos', 'is_correct' => true],
                    ['text' => 'Todos los nefrones son microscópicos', 'is_correct' => false],
                    ['text' => 'Ningún nefrón es microscópico', 'is_correct' => false],
                    ['text' => 'Todas las estructuras microscópicas son nefrones', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Si 6 trabajadores hacen una obra en 8 días, ¿cuántos días tardarán 4 trabajadores al mismo ritmo?',
                'answers' => [
                    ['text' => '12', 'is_correct' => true],
                    ['text' => '10', 'is_correct' => false],
                    ['text' => '14', 'is_correct' => false],
                    ['text' => '16', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Texto: La memoria no almacena hechos de manera exacta, sino reconstrucciones influenciadas por emociones y contexto. ¿Qué idea resume mejor?',
                'answers' => [
                    ['text' => 'La memoria depende del contexto', 'is_correct' => true],
                    ['text' => 'La memoria siempre es objetiva', 'is_correct' => false],
                    ['text' => 'Las emociones no afectan recuerdos', 'is_correct' => false],
                    ['text' => 'El cerebro almacena datos exactos', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'En una carrera rebasas al penúltimo lugar. ¿En qué posición quedas?',
                'answers' => [
                    ['text' => 'Penúltimo', 'is_correct' => true],
                    ['text' => 'Último', 'is_correct' => false],
                    ['text' => 'Antepenúltimo', 'is_correct' => false],
                    ['text' => 'Primero', 'is_correct' => false],
                ],
            ],
            [
                'text' => '8, 27, 64, 125, ___',
                'answers' => [
                    ['text' => '216', 'is_correct' => true],
                    ['text' => '150', 'is_correct' => false],
                    ['text' => '200', 'is_correct' => false],
                    ['text' => '175', 'is_correct' => false],
                ],
            ],
            [
                'text' => '1, 8, 27, 64, ___',
                'answers' => [
                    ['text' => '125', 'is_correct' => true],
                    ['text' => '81', 'is_correct' => false],
                    ['text' => '100', 'is_correct' => false],
                    ['text' => '144', 'is_correct' => false],
                ],
            ],
            [
                'text' => '2, 9, 28, 65, ___',
                'answers' => [
                    ['text' => '126', 'is_correct' => true],
                    ['text' => '100', 'is_correct' => false],
                    ['text' => '90', 'is_correct' => false],
                    ['text' => '80', 'is_correct' => false],
                ],
            ],
            [
                'text' => '0, 7, 26, 63, ___',
                'answers' => [
                    ['text' => '124', 'is_correct' => true],
                    ['text' => '100', 'is_correct' => false],
                    ['text' => '120', 'is_correct' => false],
                    ['text' => '150', 'is_correct' => false],
                ],
            ],
            [
                'text' => '9, 28, 65, 126, ___',
                'answers' => [
                    ['text' => '217', 'is_correct' => true],
                    ['text' => '200', 'is_correct' => false],
                    ['text' => '215', 'is_correct' => false],
                    ['text' => '216', 'is_correct' => false],
                ],
            ],
            [
                'text' => '1, 9, 35, 91, ___',
                'answers' => [
                    ['text' => '189', 'is_correct' => true],
                    ['text' => '150', 'is_correct' => false],
                    ['text' => '200', 'is_correct' => false],
                    ['text' => '210', 'is_correct' => false],
                ],
            ],
            [
                'text' => '1, 8, 9, 27, 16, 64, ___',
                'answers' => [
                    ['text' => '25', 'is_correct' => true],
                    ['text' => '81', 'is_correct' => false],
                    ['text' => '32', 'is_correct' => false],
                    ['text' => '36', 'is_correct' => false],
                ],
            ],
            [
                'text' => '1, 8, 27, 64, 125, 36, ___',
                'answers' => [
                    ['text' => '49', 'is_correct' => true],
                    ['text' => '64', 'is_correct' => false],
                    ['text' => '81', 'is_correct' => false],
                    ['text' => '100', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($questions as $index => $questionData) {
            $question = $exam->questions()->create([
                'text' => $questionData['text'],
                'order' => $index + 1,
            ]);

            $question->answers()->createMany($questionData['answers']);
        }
    }
}
