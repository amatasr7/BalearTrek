<?php

namespace Database\Seeders;

use App\Models\Trek;
use App\Models\InterestingPlace;
use Illuminate\Database\Seeder;

class DescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array de descripciones para treks (mapeo por regNumber)
        $trekDescriptions = [
            'T01' => 'Un recorrido espectacular por la Serra de Tramuntana central. Esta ruta es ideal para quienes desean conocer la geografía más emblemática de Mallorca, pasando por picos de gran altitud con vistas panorámicas del norte de la isla.',
            'T02' => 'Una caminata costera que ofrece magníficas vistas al Mediterráneo desde los acantilados del Llevant. Perfecta para disfrutar de la naturaleza virgen y la brisa marina.',
            'T03' => 'Ascenso al pico más emblemático de la Tramuntana. Una trek desafiante pero gratificante con vistas de 360 grados desde la cima.',
            'T04' => 'Un paseo a caballo por los paisajes rurales más auténticos de Mallorca. Ideal para familias y para quienes buscan una experiencia diferente en la naturaleza.',
            'T05' => 'Ruta fluvial que sigue el curso del Torrent de Pareis, descubriendo cascadas y piscinas naturales. Una aventura perfecta para refrescarse en verano.',
            'T06' => 'Caminata corta pero pintoresca por los alrededores de Ses Fonts. Ideal para principiantes con hermosos paisajes de bosque mediterráneo.',
            'T07' => 'Una ruta escénica a través de la Cala Figuera, con acceso a playas vírgenes y calas ocultas. Combinación perfecta de montaña y mar.',
            'T08' => 'Paseo tranquilo por los acantilados de Cala Varques, con espectaculares vistas al mar Balear. Ideal para fotografía y contemplación.',
            'T09' => 'Trekking completo que atraviesa el Torrent de Pareis hasta la costa. Una de las rutas más emocionantes de Mallorca.',
            'T10' => 'Ascenso a La Trapa, una antigua trapería en ruinas con vistas inmejorables. Una mezcla de historia y naturaleza.',
            'T11' => 'Caminata de dificultad moderada por Sa Foradada. Vistas al mar desde las alturas y acceso a calas paradisíacas.',
            'T12' => 'Ruta que visita el Puig de Massanella, second pico más alto de la Tramuntana. Vistas espectaculares y bosques primarios.',
            'T13' => 'Paseo marino por Cala Tuent, accesible gracias a este sendero bien mantendido. Playas tranquilas y agua cristalina.',
            'T14' => 'Ascenso a Sa Calobra con vistas al Mediterráneo. Una ruta corta pero con grandes recompensas visuales.',
            'T15' => 'Trek que combina Sa Calobra con el Torrent de Pareis. Una aventura completa de montaña y agua.',
            'T16' => 'Ruta panorámica por Cala Mondragó, isla privada pero con senderos accesibles. Playas vírgenes y ecosistemas únicos.',
            'T17' => 'Caminata histórica por los alrededores del Formentor. Zona de gran belleza con legado cultural.'    ,
            'T18' => 'Ruta que lleva al Puig de l\'Ofre con vistas del Valle de Sóller. Uno de los panoramas más bonitos de Mallorca.',
            'T19' => 'Paseo costero por Cala Deia, un pueblo pintoresco en las alturas. Perfecto para combinar senderismo y gastronomía.',
            'T20' => 'Caminata por el Camí des Correu, un sendero histórico. Conecta pueblos y ofrece vistas de toda la Tramuntana.',
        ];

        // Descripciones para InterestingPlaces
        $placeDescriptions = [
            'Puig de Massanella' => 'Segunda cima más alta de la Sierra de Tramuntana con vistas espectaculares de toda la isla.',
            'Cala Figuera' => 'Una bahía virgen y tranquila con aguas cristalinas, ideal para buceo y nado.',
            'Puig de l\'Ofre' => 'Cima con vistas panorámicas del valle de Sóller y las montañas circundantes.',
            'Sa Calobra' => 'Cala espectacular accesible por la famosa carretera de 13 curvas, con playas de arena dorada.',
            'Torrent de Pareis' => 'Garganta natural única en Europa que desemboca en una playa privada.',
            'Cala Tuent' => 'Playa recóndita en la costa norte, rodeada de montañas escarpadas.',
            'La Trapa' => 'Ruinas de una antigua trapería trapense con vistas al mar desde 400 metros de altitud.',
            'Formentor' => 'Península con un faro icónico y carreteras panorámicas junto a acantilados.',
            'Cala Dei' => 'Pueblo costero enclavado en los acantilados, conocido por sus artistas y paisajes.',
            'Monasterio de Lluc' => 'Santuario mariano en la montaña, centro de peregrinación y cultura majorera.',
        ];

        // Añadir descripciones a Treks
        foreach ($trekDescriptions as $regNumber => $description) {
            Trek::where('regNumber', $regNumber)
                ->update(['description' => $description]);
        }

        // Añadir descripciones a InterestingPlaces
        foreach ($placeDescriptions as $name => $description) {
            InterestingPlace::where('name', $name)
                ->update(['description' => $description]);
        }

        $this->command->info('Descripciones añadidas correctamente a treks y lugares interesantes.');
    }
}
