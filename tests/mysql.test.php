<?php

beforeAll(function () {
    // using mysqli just for wider support
    $conn = mysqli_connect('sql7.freemysqlhosting.net', 'sql7600346', 'l87WSttrMv', 'sql7600346');

    $query = '
		DROP TABLE IF EXISTS `test`;
		CREATE TABLE IF NOT EXISTS `test` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			`email` varchar(255) NOT NULL,
			`password` varchar(255) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
	';

    mysqli_multi_query($conn, $query);
    mysqli_close($conn);
});

it('connects to database', function () {
    $success = false;

    try {
        $db = new \Leaf\Db();
        expect($db->connect('sql7.freemysqlhosting.net', 'sql7600346', 'sql7600346', 'l87WSttrMv'))
            ->toBeInstanceOf(\PDO::class);
        $db->close();

        $success = true;
    } catch (\Throwable $th) {
    }

    expect($success)->toBeTrue();
});

it('inserts dummy user into `test` table', function () {
    $success = false;
    $db = new \Leaf\Db();
    $db->connect('sql7.freemysqlhosting.net', 'sql7600346', 'sql7600346', 'l87WSttrMv');

    try {
        $db->insert('test')
            ->params([
                'name' => 'Name',
                'email' => 'mail@mail.com',
                'password' => 'testing123',
            ])
            ->execute();
        $success = true;
    } catch (\Throwable $th) {
    }

	expect($success)->toBeTrue();
});
