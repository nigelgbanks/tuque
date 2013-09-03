<?php

/**
 * @file
 * This file defines an abstract repository that can be overridden and also
 * defines a concrete implementation for Fedora.
 */

namespace Tuque;
use \AbstractRepository as AbstractRepository;

require_once 'AbstractRepository.php';
require_once 'Cache.php';
require_once 'Object.php';
require_once 'RepositoryException.php';
require_once 'includes/HttpConnection.php';
require_once 'includes/Decorator.php';

/**
 * Implementation of a repository config.
 */
class RepositoryConfig {

  /**
   * Simple constructor definition for the repository.
   */
  public function __construct($url, $username = NULL, $password = NULL, AbstractCache $cache = NULL) {
    $this->url = $url;
    $this->username = $username;
    $this->password = $password;
    if ($cache == NULL) {
      $this->cache = new SimpleCache();
    }
  }
}

/**
 * This class acts as a wrapper for the actual Repository implementation.
 */
class Repository extends Decorator implements AbstractRepository {

  /**
   * The decorator class to wrap the objects that have not yet been ingested.
   * @var string
   */
  protected $newObjectDecorator = 'Tuque\NewObject';

  /**
   * The decorator class to wrap existing objects.
   * @var string
   */
  protected $objectDecorator = 'Tuque\Object';

  /**
   * Constructor for the Repository object.
   *
   * @param RepositoryConfig $config
   *   The configuration setting that defines what kind of repository to
   *   instantiate.
   */
  public function __construct(RepositoryConfig $config) {
    require_once 'implementations/RepositoryFactory.php';
    parent::__construct(RepositoryFactory::getRepository($config));
  }

  /**
   * Create a new object that has not been ingested and return it decorated.
   *
   * @see AbstractRepository::constructObject
   */
  public function constructObject($id = NULL, $create_uuid = FALSE) {
    $object = parent::constructObject($id, $create_uuid);
    return new $this->newObjectDecorator($object);
  }

  /**
   * Ingest a new object into the repository and return it decorated.
   *
   * @see AbstractRepository::ingestObject
   */
  public function ingestObject(AbstractObject &$object) {
    $object = parent::ingestObject($object);
    return new $this->objectDecorator($object);
  }

  /**
   * Gets a object from the repository and return it decorated.
   *
   * @see AbstractRepository::getObject
   */
  public function getObject($id) {
    $object = parent::getObject($id);
    return new $this->objectDecorator($object);
  }

  /**
   * Returns basic information about the Repository.
   *
   * @see AbstractRepository::describe
   */
  public function describe() {
    return parent::describe();
  }

  /**
   * Removes an object from the repository.
   *
   * @see AbstractRepository::purgeObject
   */
  public function purgeObject($id) {
    return parent::purgeObject($id);
  }

  /**
   * Search the repository for objects.
   *
   * @see AbstractRepository::findObjects
   */
  public function findObjects(array $search) {
    return parent::findObjects($search);
  }

  /**
   * Will return an unused identifier for an object.
   *
   * @see AbstractRepository::getNextIdentifier
   */
  public function getNextIdentifier($namespace = NULL, $create_uuid = FALSE, $number_of_identifiers = 1) {
    return parent::getNextIdentifier($namespace, $create_uuid, $number_of_identifiers);
  }
}
