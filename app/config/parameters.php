<?php 
$db = parse_url($container->getParameter('database_url')?:'mysql://root@localhost/symfony');
if($db['scheme']=='postgres')
	$container->setParameter('database_driver', 'pdo_pgsql' );
else
	$container->setParameter('database_driver', 'pdo_mysql' );
$container->setParameter('database_user', (isset($db['user']) ? $db['user'] : 'root'));
$container->setParameter('database_password', (isset($db['pass']) ? $db['pass'] : null));
$container->setParameter('database_host', (isset($db['host']) ? $db['host'] : 'localhost'));
if(isset($db['port'])) $container->setParameter('database_port', $db['port']);
$container->setParameter('database_name', substr($db['path'], 1));
