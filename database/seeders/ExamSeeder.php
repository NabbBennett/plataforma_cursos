<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ========================
        // EXAMEN 1: Literatura Española - Poesía y Prosa
        // ========================
        $exam1 = Exam::create([
            'title' => 'Examen de Literatura Española - Poesía y Prosa',
            'duration_minutes' => 90,
        ]);

        if ($exam1) {
            // Pregunta 1: García Lorca - Poema
            $q1 = $exam1->questions()->create([
                'text' => '<p style="text-align: center;"><strong>Lee el siguiente fragmento de Federico García Lorca:</strong></p>
<p style="text-align: center;"><em>"Verde que te quiero verde,<br>verde de la mar verde,<br>verde de la hierba,<br>amor entre nosotros."</em></p>
<p>¿Cuál es la principal característica estilística de este fragmento?</p>',
                'theme' => 'Poesía Moderna',
                'order' => 1,
            ]);
            $q1->answers()->createMany([
                ['text' => 'Uso de la anáfora con la palabra "verde"', 'is_correct' => true],
                ['text' => 'Uso de la rima consonante', 'is_correct' => false],
                ['text' => 'Uso exclusivo de métricas clásicas', 'is_correct' => false],
                ['text' => 'Uso de la paradoja y la antítesis', 'is_correct' => false],
            ]);

            // Pregunta 2: Machado - Reflexión
            $q2 = $exam1->questions()->create([
                'text' => '<p><strong>Pregunta:</strong> En los versos de Antonio Machado: <em>"Caminante, son tus huellas el camino y nada más; caminante no hay camino, se hace camino al andar"</em></p>
<p style="text-align: left;">¿Qué concepto filosófico se expresa en estos versos?</p>',
                'theme' => 'Poesía de la Generación del 98',
                'order' => 2,
            ]);
            $q2->answers()->createMany([
                ['text' => 'La vida es un proceso continuo de construcción personal', 'is_correct' => true],
                ['text' => 'La importancia del destino predeterminado', 'is_correct' => false],
                ['text' => 'La crítica a los viajeros', 'is_correct' => false],
                ['text' => 'La descrición de un camino literal', 'is_correct' => false],
            ]);

            // Pregunta 3: Cervantes - Don Quijote
            $q3 = $exam1->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Cuál es la obra maestra de Miguel de Cervantes?</strong></p>
<p style="text-align: center;">Esta novela es considerada una de las mejores obras de la literatura universal.</p>',
                'theme' => 'Prosa Clásica Española',
                'order' => 3,
            ]);
            $q3->answers()->createMany([
                ['text' => 'Don Quijote de la Mancha', 'is_correct' => true],
                ['text' => 'La Galatea', 'is_correct' => false],
                ['text' => 'Novelas ejemplares', 'is_correct' => false],
                ['text' => 'Los trabajos de Persiles y Sigismunda', 'is_correct' => false],
            ]);

            // Pregunta 4: Generación del 27
            $q4 = $exam1->questions()->create([
                'text' => '<p><strong>¿Cuál de los siguientes poetas NO pertenece a la Generación del 27?</strong></p>
<p style="text-align: left;">Recuerda que la Generación del 27 incluye a grandes nombres de la literatura española.</p>',
                'theme' => 'Generación del 27',
                'order' => 4,
            ]);
            $q4->answers()->createMany([
                ['text' => 'Benito Pérez Galdós', 'is_correct' => true],
                ['text' => 'Rafael Alberti', 'is_correct' => false],
                ['text' => 'Luis Cernuda', 'is_correct' => false],
                ['text' => 'Jorge Guillén', 'is_correct' => false],
            ]);

            // Pregunta 5: Bécquer - Rimas
            $q5 = $exam1->questions()->create([
                'text' => '<p style="text-align: center;"><em>"Volverán las oscuras golondrinas<br>en tu balcón sus nidos a colgar,<br>y otra vez con el ala a sus cristales<br>jugando llamarán."</em></p>
<p>¿De quién es este poema?</p>',
                'theme' => 'Poesía Romántica',
                'order' => 5,
            ]);
            $q5->answers()->createMany([
                ['text' => 'Gustavo Adolfo Bécquer', 'is_correct' => true],
                ['text' => 'José de Espronceda', 'is_correct' => false],
                ['text' => 'Mariano José de Larra', 'is_correct' => false],
                ['text' => 'Manuel Bretón de los Herreros', 'is_correct' => false],
            ]);

            // Pregunta 6: Larra - Artículos
            $q6 = $exam1->questions()->create([
                'text' => '<p><strong>Mariano José de Larra</strong> fue conocido por escribir:</p>
<p style="text-align: left;">Este escritor utilizaba la crítica social como herramienta literaria.</p>',
                'theme' => 'Crítica y Ensayo',
                'order' => 6,
            ]);
            $q6->answers()->createMany([
                ['text' => 'Artículos satíricos y críticos bajo pseudónimos', 'is_correct' => true],
                ['text' => 'Únicamente novelas de aventura', 'is_correct' => false],
                ['text' => 'Tratados científicos', 'is_correct' => false],
                ['text' => 'Poesía épica exclusivamente', 'is_correct' => false],
            ]);

            // Pregunta 7: Ortega y Gasset
            $q7 = $exam1->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Cuál es la frase más famosa de José Ortega y Gasset?</strong></p>',
                'theme' => 'Filosofía y Ensayo',
                'order' => 7,
            ]);
            $q7->answers()->createMany([
                ['text' => '"Yo soy yo y mi circunstancia"', 'is_correct' => true],
                ['text' => '"La vida es sueño"', 'is_correct' => false],
                ['text' => '"Todo está permitido"', 'is_correct' => false],
                ['text' => '"Ser o no ser"', 'is_correct' => false],
            ]);

            // Pregunta 8: Calderón - Teatro
            $q8 = $exam1->questions()->create([
                'text' => '<p><strong>¿Cuál es la obra más famosa de Calderón de la Barca?</strong></p>
<p style="text-align: center;">Pista: Trata sobre un príncipe que vive en una torre.</p>',
                'theme' => 'Teatro Barroco',
                'order' => 8,
            ]);
            $q8->answers()->createMany([
                ['text' => 'La vida es sueño', 'is_correct' => true],
                ['text' => 'El alcalde de Zalamea', 'is_correct' => false],
                ['text' => 'La dama duende', 'is_correct' => false],
                ['text' => 'El mágico prodigioso', 'is_correct' => false],
            ]);

            // Pregunta 9: Góngora - Gongorismo
            $q9 = $exam1->questions()->create([
                'text' => '<p><strong>¿Qué es el gongorismo?</strong></p>
<p style="text-align: left;">Responde basándote en el estilo de Luis de Góngora.</p>',
                'theme' => 'Conceptos Literarios',
                'order' => 9,
            ]);
            $q9->answers()->createMany([
                ['text' => 'Un estilo poético caracterizado por la complejidad, la hipérbole y cultismos', 'is_correct' => true],
                ['text' => 'Un movimiento teatral del siglo XVIII', 'is_correct' => false],
                ['text' => 'Una novela picaresca', 'is_correct' => false],
                ['text' => 'Un tipo de verso libre', 'is_correct' => false],
            ]);

            // Pregunta 10: Picaresca española
            $q10 = $exam1->questions()->create([
                'text' => '<p><strong>¿Cuál es la característica principal de la novela picaresca española?</strong></p>
<p style="text-align: center;">Ejemplo: <em>Lazarillo de Tormes</em></p>',
                'theme' => 'Novela Picaresca',
                'order' => 10,
            ]);
            $q10->answers()->createMany([
                ['text' => 'Un protagonista de clase baja cuenta sus aventuras y desvenencias en primera persona', 'is_correct' => true],
                ['text' => 'Una familia noble vive en el campo', 'is_correct' => false],
                ['text' => 'Un héroe medieval busca aventuras románticas', 'is_correct' => false],
                ['text' => 'Un científico realiza experimentos', 'is_correct' => false],
            ]);

            // Pregunta 11: Valle-Inclán - Esperpentos
            $q11 = $exam1->questions()->create([
                'text' => '<p><strong>Ramón María del Valle-Inclán creó un estilo único llamado:</strong></p>
<p style="text-align: left;">Este estilo presenta una visión deformada y crítica de la realidad.</p>',
                'theme' => 'Literatura Contemporánea',
                'order' => 11,
            ]);
            $q11->answers()->createMany([
                ['text' => 'Esperpento', 'is_correct' => true],
                ['text' => 'Futurismo', 'is_correct' => false],
                ['text' => 'Modernismo', 'is_correct' => false],
                ['text' => 'Naturalismo', 'is_correct' => false],
            ]);

            // Pregunta 12: Borges - Cuentos (autor argentino pero influencia española)
            $q12 = $exam1->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Cuál es el tema central en muchos cuentos de Jorge Luis Borges?</strong></p>
<p style="text-align: center;">Aunque es argentino, su obra influyó enormemente en la literatura de habla hispana.</p>',
                'theme' => 'Influencias en la Literatura Española',
                'order' => 12,
            ]);
            $q12->answers()->createMany([
                ['text' => 'Los laberintos del tiempo, la memoria y la realidad', 'is_correct' => true],
                ['text' => 'La política revolucionaria', 'is_correct' => false],
                ['text' => 'Las aventuras de piratas', 'is_correct' => false],
                ['text' => 'Los amores imposibles', 'is_correct' => false],
            ]);

            // Pregunta 13: Unamuno - Nivola
            $q13 = $exam1->questions()->create([
                'text' => '<p><strong>¿Qué es una "nivola" según Miguel de Unamuno?</strong></p>',
                'theme' => 'Formas Narrativas',
                'order' => 13,
            ]);
            $q13->answers()->createMany([
                ['text' => 'Un tipo de novela diferente a las tradicionales, enfocada en el drama íntimo', 'is_correct' => true],
                ['text' => 'Una novela ambientada en la nieve', 'is_correct' => false],
                ['text' => 'Una novela francesa del siglo XIX', 'is_correct' => false],
                ['text' => 'Un tipo de poesía épica', 'is_correct' => false],
            ]);

            // Pregunta 14: Baroja - Novelas
            $q14 = $exam1->questions()->create([
                'text' => '<p style="text-align: left;"><strong>Pío Baroja escribió numerosas novelas. ¿Cuál es la característica de su obra literaria?</strong></p>
<p style="text-align: left;">Sus novelas reflejan la realidad española de su época.</p>',
                'theme' => 'Generación del 98 - Prosa',
                'order' => 14,
            ]);
            $q14->answers()->createMany([
                ['text' => 'Novelas de crítica social, acción y personajes complejos', 'is_correct' => true],
                ['text' => 'Novelas románticas exclusivamente', 'is_correct' => false],
                ['text' => 'Novelas de ciencia ficción', 'is_correct' => false],
                ['text' => 'Novelas históricas sin crítica social', 'is_correct' => false],
            ]);

            // Pregunta 15: Rosalía de Castro
            $q15 = $exam1->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿De dónde era originaria Rosalía de Castro?</strong></p>
<p style="text-align: center;"><em>"Cantares Gallegos"</em> es su obra más famosa.</p>',
                'theme' => 'Literatura Gallegoportuguesa',
                'order' => 15,
            ]);
            $q15->answers()->createMany([
                ['text' => 'Galicia', 'is_correct' => true],
                ['text' => 'Cataluña', 'is_correct' => false],
                ['text' => 'Castilla', 'is_correct' => false],
                ['text' => 'Andalucía', 'is_correct' => false],
            ]);
        }

        // ========================
        // EXAMEN 2: Historia de España - De los Reyes Católicos a la Guerra Civil
        // ========================
        $exam2 = Exam::create([
            'title' => 'Examen de Historia de España - Período Medieval y Moderno',
            'duration_minutes' => 100,
        ]);

        if ($exam2) {
            // Pregunta 1: Reyes Católicos
            $q1 = $exam2->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿En qué año concluyó la Reconquista con los Reyes Católicos?</strong></p>
<p style="text-align: center;">Pista: Fue el mismo año del viaje de Colón a América.</p>',
                'theme' => 'Reino de los Reyes Católicos',
                'order' => 1,
            ]);
            $q1->answers()->createMany([
                ['text' => '1492', 'is_correct' => true],
                ['text' => '1469', 'is_correct' => false],
                ['text' => '1512', 'is_correct' => false],
                ['text' => '1479', 'is_correct' => false],
            ]);

            // Pregunta 2: Napoleón
            $q2 = $exam2->questions()->create([
                'text' => '<p><strong>¿Cuál fue el mayor conflicto en España durante el reinado de Carlos IV?</strong></p>
<p style="text-align: left;">Considera los sucesos relacionados con Napoleón.</p>',
                'theme' => 'España en Tiempos de Napoleón',
                'order' => 2,
            ]);
            $q2->answers()->createMany([
                ['text' => 'La invasión francesa y la Guerra de la Independencia (1808-1814)', 'is_correct' => true],
                ['text' => 'Una rebelión interna de nobles', 'is_correct' => false],
                ['text' => 'Una guerra civil entre provincias', 'is_correct' => false],
                ['text' => 'Un levantamiento campesino', 'is_correct' => false],
            ]);

            // Pregunta 3: Revolución Industrial
            $q3 = $exam2->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Por qué España se quedó rezagada durante la Revolución Industrial?</strong></p>',
                'theme' => 'Siglo XIX - Modernización',
                'order' => 3,
            ]);
            $q3->answers()->createMany([
                ['text' => 'Falta de capital, atraso tecnológico y conflictos políticos internos', 'is_correct' => true],
                ['text' => 'Porque rechazó deliberadamente la tecnología', 'is_correct' => false],
                ['text' => 'Porque no tenía suficientes minerales', 'is_correct' => false],
                ['text' => 'Porque el clima lo impedía', 'is_correct' => false],
            ]);

            // Pregunta 4: Carlismo
            $q4 = $exam2->questions()->create([
                'text' => '<p><strong>¿Cuál fue la causa principal de las Guerras Carlistas en España?</strong></p>
<p style="text-align: center;">Estas guerras dominaron buena parte del siglo XIX.</p>',
                'theme' => 'Conflictos Internos del XIX',
                'order' => 4,
            ]);
            $q4->answers()->createMany([
                ['text' => 'La disputa por la sucesión al trono entre liberales y carlistas', 'is_correct' => true],
                ['text' => 'Una rebelión campesina contra los impuestos', 'is_correct' => false],
                ['text' => 'Un conflicto religioso entre católicos y protestantes', 'is_correct' => false],
                ['text' => 'Una invasión extranjera', 'is_correct' => false],
            ]);

            // Pregunta 5: Pérdida del Imperio
            $q5 = $exam2->questions()->create([
                'text' => '<p style="text-align: left;"><strong>¿En qué año España perdió sus últimas colonias significativas (Cuba, Filipinas, Puerto Rico)?</strong></p>
<p style="text-align: left;">Este evento es conocido como la "Generación del 98".</p>',
                'theme' => 'Fin del Imperio Español',
                'order' => 5,
            ]);
            $q5->answers()->createMany([
                ['text' => '1898', 'is_correct' => true],
                ['text' => '1875', 'is_correct' => false],
                ['text' => '1912', 'is_correct' => false],
                ['text' => '1895', 'is_correct' => false],
            ]);

            // Pregunta 6: II República
            $q6 = $exam2->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿En qué año se proclamó la Segunda República Española?</strong></p>',
                'theme' => 'Segunda República (1931-1939)',
                'order' => 6,
            ]);
            $q6->answers()->createMany([
                ['text' => '1931', 'is_correct' => true],
                ['text' => '1928', 'is_correct' => false],
                ['text' => '1933', 'is_correct' => false],
                ['text' => '1930', 'is_correct' => false],
            ]);

            // Pregunta 7: Guerra Civil
            $q7 = $exam2->questions()->create([
                'text' => '<p><strong>¿Cuántos años duró la Guerra Civil Española?</strong></p>
<p style="text-align: center;">Un conflicto que marcó profundamente la historia española.</p>',
                'theme' => 'Guerra Civil Española (1936-1939)',
                'order' => 7,
            ]);
            $q7->answers()->createMany([
                ['text' => '3 años (1936-1939)', 'is_correct' => true],
                ['text' => '5 años (1933-1938)', 'is_correct' => false],
                ['text' => '2 años (1936-1938)', 'is_correct' => false],
                ['text' => '4 años (1936-1940)', 'is_correct' => false],
            ]);

            // Pregunta 8: Ramón y Cajal
            $q8 = $exam2->questions()->create([
                'text' => '<p style="text-align: left;"><strong>¿Cuál fue el logro científico de Santiago Ramón y Cajal?</strong></p>',
                'theme' => 'Ciencia Española del XIX',
                'order' => 8,
            ]);
            $q8->answers()->createMany([
                ['text' => 'Ganador del Premio Nobel por sus estudios sobre la estructura del sistema nervioso', 'is_correct' => true],
                ['text' => 'Inventor del primer televisor español', 'is_correct' => false],
                ['text' => 'Descubridor de una nueva especie animal', 'is_correct' => false],
                ['text' => 'Fundador de la Academia Real Española', 'is_correct' => false],
            ]);

            // Pregunta 9: Isabel II
            $q9 = $exam2->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Por qué motivo abdicó Isabel II en 1868?</strong></p>',
                'theme' => 'Monarquía del XIX',
                'order' => 9,
            ]);
            $q9->answers()->createMany([
                ['text' => 'Por presión popular y conflictos políticos tras el "Bienio Progresista"', 'is_correct' => true],
                ['text' => 'Porque deseaba retirarse voluntariamente', 'is_correct' => false],
                ['text' => 'Porque fue capturada por tropas extranjeras', 'is_correct' => false],
                ['text' => 'Porque tuvo un accidente', 'is_correct' => false],
            ]);

            // Pregunta 10: Restauración Borbónica
            $q10 = $exam2->questions()->create([
                'text' => '<p><strong>¿Quién encabezó la Restauración Borbónica en 1875?</strong></p>
<p style="text-align: center;">Este período trajo cierta estabilidad política a España.</p>',
                'theme' => 'Restauración y Sexenio Democrático',
                'order' => 10,
            ]);
            $q10->answers()->createMany([
                ['text' => 'Alfonso XII', 'is_correct' => true],
                ['text' => 'Juan Carlos I', 'is_correct' => false],
                ['text' => 'Fernando VII', 'is_correct' => false],
                ['text' => 'Amadeo I', 'is_correct' => false],
            ]);

            // Pregunta 11: Constitución de 1978
            $q11 = $exam2->questions()->create([
                'text' => '<p style="text-align: left;"><strong>¿Cuál fue el contexto histórico para la redacción de la Constitución de 1978?</strong></p>',
                'theme' => 'España Contemporánea',
                'order' => 11,
            ]);
            $q11->answers()->createMany([
                ['text' => 'La transición democrática tras la muerte de Franco', 'is_correct' => true],
                ['text' => 'La Guerra Civil', 'is_correct' => false],
                ['text' => 'La Revolución Francesa', 'is_correct' => false],
                ['text' => 'El fin de la II República', 'is_correct' => false],
            ]);

            // Pregunta 12: Franquismo
            $q12 = $exam2->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Cuántos años duró la dictadura de Francisco Franco?</strong></p>',
                'theme' => 'Franquismo (1939-1975)',
                'order' => 12,
            ]);
            $q12->answers()->createMany([
                ['text' => '36 años', 'is_correct' => true],
                ['text' => '25 años', 'is_correct' => false],
                ['text' => '45 años', 'is_correct' => false],
                ['text' => '30 años', 'is_correct' => false],
            ]);

            // Pregunta 13: Autonomías
            $q13 = $exam2->questions()->create([
                'text' => '<p><strong>¿Cuál de las siguientes regiones no fue considerada nacionalidad histórica por la Constitución de 1978?</strong></p>',
                'theme' => 'Organización Territorial',
                'order' => 13,
            ]);
            $q13->answers()->createMany([
                ['text' => 'Castilla y León', 'is_correct' => true],
                ['text' => 'Cataluña', 'is_correct' => false],
                ['text' => 'Euskadi', 'is_correct' => false],
                ['text' => 'Galicia', 'is_correct' => false],
            ]);

            // Pregunta 14: Tratado de Tordesillas
            $q14 = $exam2->questions()->create([
                'text' => '<p style="text-align: left;"><strong>¿Cuál fue la importancia del Tratado de Tordesillas (1494)?</strong></p>',
                'theme' => 'Expansión Colonial',
                'order' => 14,
            ]);
            $q14->answers()->createMany([
                ['text' => 'Dividir el mundo entre España y Portugal en territorios a explorar y colonizar', 'is_correct' => true],
                ['text' => 'Crear una alianza militar contra Francia', 'is_correct' => false],
                ['text' => 'Establec un tratado comercial', 'is_correct' => false],
                ['text' => 'Resolver un conflicto religioso', 'is_correct' => false],
            ]);

            // Pregunta 15: Juan de los Reyes
            $q15 = $exam2->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿En qué ciudad se encuentra el monasterio de San Juan de los Reyes?</strong></p>
<p style="text-align: center;">Fue fundado por los Reyes Católicos.</p>',
                'theme' => 'Patrimonio Histórico',
                'order' => 15,
            ]);
            $q15->answers()->createMany([
                ['text' => 'Toledo', 'is_correct' => true],
                ['text' => 'Sevilla', 'is_correct' => false],
                ['text' => 'Granada', 'is_correct' => false],
                ['text' => 'Salamanca', 'is_correct' => false],
            ]);
        }

        // ========================
        // EXAMEN 3: Filosofía Española - Del Renacimiento a la Contemporaneidad
        // ========================
        $exam3 = Exam::create([
            'title' => 'Examen de Filosofía Española - Pensadores y Corrientes',
            'duration_minutes' => 85,
        ]);

        if ($exam3) {
            // Pregunta 1: Fray Luis de León
            $q1 = $exam3->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Cuál fue la principal contribución de Fray Luis de León?</strong></p>
<p style="text-align: center;"><em>"Aquí la envidia y mentira me tuvieron encerrado..."</em></p>',
                'theme' => 'Humanismo Español del XVI',
                'order' => 1,
            ]);
            $q1->answers()->createMany([
                ['text' => 'Filosofía humanista combinada con la expresión poética y mística', 'is_correct' => true],
                ['text' => 'Únicamente filosofía escolástica', 'is_correct' => false],
                ['text' => 'Ciencia experimental exclusivamente', 'is_correct' => false],
                ['text' => 'Crítica sistemática de la religión', 'is_correct' => false],
            ]);

            // Pregunta 2: Feijoo
            $q2 = $exam3->questions()->create([
                'text' => '<p><strong>¿Cuál fue el propósito de los <em>Ensayos Escépticos</em> de Benito Jerónimo Feijoo?</strong></p>
<p style="text-align: left;">Este intelectual fue pionero de la Ilustración española.</p>',
                'theme' => 'Ilustración Española',
                'order' => 2,
            ]);
            $q2->answers()->createMany([
                ['text' => 'Cuestionar creencias populares y supersticiones mediante la razón', 'is_correct' => true],
                ['text' => 'Defender exclusivamente el catolicismo tradicional', 'is_correct' => false],
                ['text' => 'Propagar ideas revolucionarias', 'is_correct' => false],
                ['text' => 'Criticar solamente al gobierno', 'is_correct' => false],
            ]);

            // Pregunta 3: Quevedo - Filosofía
            $q3 = $exam3->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Cuál era el pensamiento filosófico central de Francisco de Quevedo?</strong></p>',
                'theme' => 'Barroco Español',
                'order' => 3,
            ]);
            $q3->answers()->createMany([
                ['text' => 'La vanidad, la mortalidad y la futilidad de la vida', 'is_correct' => true],
                ['text' => 'El optimismo radical', 'is_correct' => false],
                ['text' => 'El relativismo ético', 'is_correct' => false],
                ['text' => 'El determinismo científico', 'is_correct' => false],
            ]);

            // Pregunta 4: Menéndez Pelayo
            $q4 = $exam3->questions()->create([
                'text' => '<p><strong>¿Cuál fue la obra magna de Marcelino Menéndez Pelayo?</strong></p>
<p style="text-align: left;">Una monumental obra sobre la cultura española.</p>',
                'theme' => 'Crítica e Historia de la Filosofía',
                'order' => 4,
            ]);
            $q4->answers()->createMany([
                ['text' => '<em>Historia de los heterodoxos españoles</em>', 'is_correct' => true],
                ['text' => '<em>La España Negra</em>', 'is_correct' => false],
                ['text' => '<em>Teoría de la Evolución</em>', 'is_correct' => false],
                ['text' => '<em>La República</em>', 'is_correct' => false],
            ]);

            // Pregunta 5: Ortega y Gasset - Filosofía
            $q5 = $exam3->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Cuál es el concepto fundamental en la filosofía de Ortega y Gasset?</strong></p>',
                'theme' => 'Filosofía del XX',
                'order' => 5,
            ]);
            $q5->answers()->createMany([
                ['text' => 'La razón vital: "Yo soy yo y mi circunstancia"', 'is_correct' => true],
                ['text' => 'El existencialismo puro', 'is_correct' => false],
                ['text' => 'El materialismo histórico', 'is_correct' => false],
                ['text' => 'El idealismo cartesiano', 'is_correct' => false],
            ]);

            // Pregunta 6: Unamuno - Filosofía
            $q6 = $exam3->questions()->create([
                'text' => '<p style="text-align: left;"><strong>¿Cuál es la obsesión central en el pensamiento filosófico de Miguel de Unamuno?</strong></p>',
                'theme' => 'Existencialismo Español',
                'order' => 6,
            ]);
            $q6->answers()->createMany([
                ['text' => 'La angustia frente a la muerte y la inmortalidad del alma', 'is_correct' => true],
                ['text' => 'El análisis lingüístico', 'is_correct' => false],
                ['text' => 'La lógica matemática', 'is_correct' => false],
                ['text' => 'La economía política', 'is_correct' => false],
            ]);

            // Pregunta 7: Negrín - Filósofo
            $q7 = $exam3->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Cuál era la orientación filosófica de Juan Negrín (filósofo, no el político)?</strong></p>
<p style="text-align: center;">Aunque menos conocido, fue un importante pensador español.</p>',
                'theme' => 'Filosofía Contemporánea',
                'order' => 7,
            ]);
            $q7->answers()->createMany([
                ['text' => 'El pragmatismo y la filosofía vitalista', 'is_correct' => true],
                ['text' => 'El positivismo lógico puro', 'is_correct' => false],
                ['text' => 'El marxismo ortogonal', 'is_correct' => false],
                ['text' => 'El solipsismo', 'is_correct' => false],
            ]);

            // Pregunta 8: Zubiri - Metafísica
            $q8 = $exam3->questions()->create([
                'text' => '<p><strong>¿Cuál fue la aportación principal de Xavier Zubiri a la filosofía española?</strong></p>
<p style="text-align: center;">Fue discípulo de Heidegger e Husserl.</p>',
                'theme' => 'Metafísica Contemporánea',
                'order' => 8,
            ]);
            $q8->answers()->createMany([
                ['text' => 'Una reformulación de la metafísica desde la perspectiva de la "realidad"', 'is_correct' => true],
                ['text' => 'Una crítica total de la metafísica', 'is_correct' => false],
                ['text' => 'Una teoría sobre lingüística pura', 'is_correct' => false],
                ['text' => 'Un retorno exclusivo al escolasticismo', 'is_correct' => false],
            ]);

            // Pregunta 9: Dilthey - Influencia en España
            $q9 = $exam3->questions()->create([
                'text' => '<p style="text-align: left;"><strong>¿Cómo influyó la filosofía de Dilthey en la filosofía española del siglo XX?</strong></p>',
                'theme' => 'Influencias Filosóficas',
                'order' => 9,
            ]);
            $q9->answers()->createMany([
                ['text' => 'A través de pensadores como Ortega que adoptaron sus ideas sobre la historicidad', 'is_correct' => true],
                ['text' => 'No tuvo ninguna influencia', 'is_correct' => false],
                ['text' => 'Solo en la lógica formal', 'is_correct' => false],
                ['text' => 'Únicamente en la ética medieval', 'is_correct' => false],
            ]);

            // Pregunta 10: Suárez - Filósofo escolástico
            $q10 = $exam3->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Quién fue Francisco Suárez y cuál fue su contribución?</strong></p>',
                'theme' => 'Escolasticismo Español',
                'order' => 10,
            ]);
            $q10->answers()->createMany([
                ['text' => 'Filósofo jesuita del XVI-XVII que modernizó la filosofía escolástica', 'is_correct' => true],
                ['text' => 'Un filósofo empirista inglés', 'is_correct' => false],
                ['text' => 'Un matemático del Renacimiento', 'is_correct' => false],
                ['text' => 'Un teólogo protestante', 'is_correct' => false],
            ]);

            // Pregunta 11: María Zambrano
            $q11 = $exam3->questions()->create([
                'text' => '<p><strong>¿Cuál fue la temática central en la obra filosófica de María Zambrano?</strong></p>
<p style="text-align: center;">Una de las pocas filósofas españolas de importancia del XX.</p>',
                'theme' => 'Filosofía Femenina Española',
                'order' => 11,
            ]);
            $q11->answers()->createMany([
                ['text' => 'La razón poética y la expiación moral', 'is_correct' => true],
                ['text' => 'La lógica simbólica exclusivamente', 'is_correct' => false],
                ['text' => 'La crítica del arte exclusivamente', 'is_correct' => false],
                ['text' => 'La física cuántica', 'is_correct' => false],
            ]);

            // Pregunta 12: Positivismo en España
            $q12 = $exam3->questions()->create([
                'text' => '<p style="text-align: left;"><strong>¿Cómo fue recibido el positivismo de Comte en España?</strong></p>',
                'theme' => 'Filosofía del XIX',
                'order' => 12,
            ]);
            $q12->answers()->createMany([
                ['text' => 'Con resistencia inicial pero luego influyó en pensadores reformistas', 'is_correct' => true],
                ['text' => 'Fue completamente rechazado', 'is_correct' => false],
                ['text' => 'Fue aceptado sin críticas', 'is_correct' => false],
                ['text' => 'No tuvo ninguna influencia', 'is_correct' => false],
            ]);

            // Pregunta 13: Escolástica Española
            $q13 = $exam3->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Cuál fue la Universidad española más importante para la filosofía escolástica?</strong></p>',
                'theme' => 'Centros de Saber Medieval y Moderno',
                'order' => 13,
            ]);
            $q13->answers()->createMany([
                ['text' => 'La Universidad de Salamanca', 'is_correct' => true],
                ['text' => 'La Universidad de Madrid', 'is_correct' => false],
                ['text' => 'La Universidad de Barcelona', 'is_correct' => false],
                ['text' => 'La Universidad de Granada', 'is_correct' => false],
            ]);

            // Pregunta 14: Kropotkin - Anarquismo en España
            $q14 = $exam3->questions()->create([
                'text' => '<p><strong>¿Cuál fue el impacto del anarquismo ruso en la filosofía política española?</strong></p>
<p style="text-align: center;">Pensadores rusos influenciaron el movimiento obrero español.</p>',
                'theme' => 'Filosofía Política',
                'order' => 14,
            ]);
            $q14->answers()->createMany([
                ['text' => 'Influyó significativamente en el movimiento obrero y anarquista español', 'is_correct' => true],
                ['text' => 'No tuvo ninguna influencia', 'is_correct' => false],
                ['text' => 'Solo afectó a la monarquía', 'is_correct' => false],
                ['text' => 'Únicamente en la religión', 'is_correct' => false],
            ]);

            // Pregunta 15: Escolio - El término
            $q15 = $exam3->questions()->create([
                'text' => '<p style="text-align: center;"><strong>¿Qué significa el término "escolio" en filosofía?</strong></p>
<p style="text-align: center;">Un término frecuente en la filosofía española tradicional.</p>',
                'theme' => 'Terminología Filosófica',
                'order' => 15,
            ]);
            $q15->answers()->createMany([
                ['text' => 'Una nota o comentario aclaratorio sobre un texto filosófico', 'is_correct' => true],
                ['text' => 'Una proposición lógica fundamental', 'is_correct' => false],
                ['text' => 'Un sistema de categorías metafísicas', 'is_correct' => false],
                ['text' => 'Un tipo de silogismo', 'is_correct' => false],
            ]);
        }
    }
}