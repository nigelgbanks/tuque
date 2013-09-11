<?php

/**
 * @file
 * Returns the correct repository given the configuration if possible.
 */

namespace Tuque;

class RepositoryFactory {

  /**
   * Gets a repository given the repositories configuration.
   */
  public static function getRepository(RepositoryConfig $config) {
    // Cache configuration should probably belong to the decorator or at least,
    // be specified by the config.
    $description = self::describe($config);
    $version = $description['version'];
    /*
    if (version_compare($version, '4.0.0', '>=')) {
      $api = new Fedora\v4\Api(new Fedora\v4\RepositoryConnection($config), new Fedora\v4\ApiSerializer());
      return new Fedora\v4\Repository($api, $config->cache);
      }else*/
    if (version_compare($version, '3.0.0', '>=')) {
      require_once 'fedora3/Datastream.php';
      require_once 'fedora3/Api.php';
      require_once 'fedora3/ApiSerializer.php';
      require_once 'fedora3/Object.php';
      require_once 'fedora3/RepositoryConnection.php';
      require_once 'fedora3/Repository.php';
      require_once 'fedora3/Relationships.php';
      $api = new Fedora\v3\FedoraApi(new Fedora\v3\RepositoryConnection($config), new Fedora\v3\FedoraApiSerializer());
      return new Fedora\v3\FedoraRepository($api, $config->cache);
    }
    throw new RepositoryBadArguementException("$type is not a supported repository type.");
  }

  private static function describe(RepositoryConfig $config) {
    // Stubbed for now.
    return array(
      'type' => 'fedora',
      'version' => '3.6.2'
    );
  }
}
