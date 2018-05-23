# Transferer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/trafficgate/transferer.svg?style=flat-square)](https://packagist.org/packages/trafficgate/transferer)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/trafficgate/transferer/master.svg?style=flat-square)](https://travis-ci.org/trafficgate/transferer)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/570aea2e-04a4-4da6-b213-e2d1dc81374f.svg?style=flat-square)](https://insight.sensiolabs.com/projects/570aea2e-04a4-4da6-b213-e2d1dc81374f)
[![StyleCI](https://styleci.io/repos/69934323/shield?branch=master)](https://styleci.io/repos/69934323)
[![Total Downloads](https://img.shields.io/packagist/dt/trafficgate/transferer.svg?style=flat-square)](https://packagist.org/packages/trafficgate/transferer)

Helper PHP objects to handle rsync, scp, and ssh-based file transfers.

## rsync

The available switches for rsync currently mirror those available in rsync on CentOS 6.x.

The following switches are not yet implemented:
  - turning off options with the `no-` prefix
  - sending remote-only options with the `remote-` prefix

Full documentation can be found in the RsyncTransfer class.

```php
<?php

use Trafficgate\Transferer\Transfer\RsyncTransfer;

$rsync = new RsyncTransfer();
$rsync
    ->source($source, $host = null, $user = null)
    ->destination($destination, $host = null, $user = null)
    ->transfer($idleTimeout = null);
```

## scp

The available switches for ssh currently mirror those available in rsync on CentOS 6.x.

Full documentation can be found in the ScpTransfer class.

```php
<?php

use Trafficgate\Transferer\Transfer\ScpTransfer;

$scp = new ScpTransfer();
$scp
    ->source($source, $host = null, $user = null)
    ->destination($destination, $host = null, $user = null)
    ->transfer($idleTimeout = null);
```

## ssh

The SSH implementation is very primitive. It will most likely be transferred to a different package in the future as it doesn't completely align with the goals of this package.

It currently implements the following switches:

  - Enable quiet mode

    ```php
    $ssh->quietMode($enabled = true)
    ```

  - Add a SSH configuration option

    ```php
    $ssh->configOptions($value, $remove = false, $enabled = true)
    ```

  - The host to connect to. This should include `username@` if it differs   from the user executing the PHP script.

    ```php
    $ssh->host($host)
    ```

  - The command to execute over SSH

    ```php
    $ssh->remoteCommand($command)
    ```


The command has quiet mode enabled by default along with the following SSH options:
  - `BatchMode yes`
  - `StrictHostKeyChecking no`
  - `UserKnownHostsFile /dev/null`

```php
<?php

use Trafficgate\Transferer\Ssh\SshCommand;

$ssh = new SshCommand();
$ssh
    ->host($host)
    ->remoteCommand($command);
```
