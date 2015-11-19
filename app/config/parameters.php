<?php 

$db = parse_url(getenv('DATABASE_URL')?:'mysql://root@localhost/symfony');
if($db['scheme']=='postgres')
	$container->setParameter('database_driver', 'pdo_pgsql' );
else
	$container->setParameter('database_driver', 'pdo_mysql' );
$container->setParameter('database_user', (isset($db['user']) ? $db['user'] : 'root'));
$container->setParameter('database_password', (isset($db['pass']) ? $db['pass'] : null));
$container->setParameter('database_host', (isset($db['hotst']) ? $db['host'] : 'localhost'));
if(isset($db['port'])) $container->setParameter('database_port', $db['port']);
$container->setParameter('database_name', substr($db['path'], 1));