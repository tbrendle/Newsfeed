<?php 
$db = parse_url($container->getParameter('DATABASE_URL')?:'postgres://jjvhdirzunlfhh:viGCzzAMpVEdetbRGnwAWigDKd@ec2-54-83-199-54.compute-1.amazonaws.com:5432/d5jt81oobt993g');
if($db['scheme']=='postgres')
	$container->setParameter('database_driver', 'pdo_pgsql' );
else
	$container->setParameter('database_driver', 'pdo_mysql' );
$container->setParameter('database_user', (isset($db['user']) ? $db['user'] : 'root'));
$container->setParameter('database_password', (isset($db['pass']) ? $db['pass'] : null));
$container->setParameter('database_host', (isset($db['host']) ? $db['host'] : 'localhost'));
if(isset($db['port'])) $container->setParameter('database_port', $db['port']);
$container->setParameter('database_name', substr($db['path'], 1));
