posts
=====

REQUIREMENT:

    (code test requirement hide for privacy protection)

DESCRIPTION:

    - Output format is configurable inside config.php (output_format)
    - Formattable JSONFormatter needs to be created in order to support json export
    - Class SimplePostExporter is in charge of export Posts with id only.
    - In order to support detail output, new class with Exportable interface needs to be created.

USAGE:
    
    []$ php main.php data/posts.csv


FILES:

    .
    ├── config.php
    ├── data
    │   └── posts.csv
    ├── init.php
    ├── main.php
    ├── model
    │   ├── CSVFormatter.class.php
    │   ├── Exportable.interface.php
    │   ├── Formattable.interface.php
    │   ├── Post.class.php
    │   ├── PostProcesser.class.php
    │   ├── PostWriter.class.php
    │   └── SimplePostExporter.class.php
    ├── output
    │   ├── daily_top_posts.csv
    │   ├── other_posts.csv
    │   └── top_posts.csv
    ├── README.md
    ├── script
    └── test
        └── GeneralTest.php

