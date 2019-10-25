<?php

  /*
    Define constantes del sistema, utilizadas por las vistas para generalizar
    la definicion de titulos y demas contenidos estaticos.
  */

  return [
      'content' => [
          'name' => 'Gestion-Procesos',
          'description' => '',
          'copyright' => 'Todos los derechos reservados. 2019',
      ],
      'contact' => [
        'email' => 'sporte.gestproc@gmail.com',
        'phone' => '+5493446633075',
      ],

      'initial_states' => [
        'Inicial' => 1,
        'Pendiente' => 2,
        'Tomado' => 3,
        'Pausado' => 4,
        'Finalizado' => 5,
        'Rechazado' => 6,
      ],
      
  ];
