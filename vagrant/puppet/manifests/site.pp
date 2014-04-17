# Run apt-get update before installing any packages.
exec { 'apt-get-update':
  command => 'apt-get update',
  path    => ['/usr/bin'],
}

Exec['apt-get-update'] -> Package <| |>

# Install and configure php5-fpm.
class php {
  package { ['php5-cli', 'php5-fpm']:
    ensure => latest,
  }
  file { '/etc/php5/fpm/pool.d/www.conf':
    owner   => root,
    group   => root,
    mode    => '0644',
    source  => 'puppet:///files/php5-fpm/www.conf',
    require => Package['php5-fpm'],
  }
  service { 'php5-fpm':
    ensure    => running,
    enable    => true,
    subscribe => File['/etc/php5/fpm/pool.d/www.conf'],
  }
}

# Install and configure Nginx.
class nginx {
  package { 'nginx':
    ensure => latest,
  }
  file { '/etc/nginx/sites-available/default':
    owner   => root,
    group   => root,
    mode    => '0644',
    source  => 'puppet:///files/nginx/default',
    require => Package['nginx'],
  }
  service { 'nginx':
    ensure    => running,
    enable    => true,
    subscribe => File['/etc/nginx/sites-available/default'],
  }
}

node default {
  include php
  include nginx
}
