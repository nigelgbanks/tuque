<?php

/**
 * @file
 * Wrapper class for the Repository Object class implementation.
 *
 * @todo We need to move away from having hard-coded properties like
 * $logMessage.
 * @todo We need to make AbstractObject an interface.
 */

namespace Tuque;
use \AbstractObject as AbstractObject;

require_once 'AbstractObject.php';
require_once 'Datastream.php';
require_once 'includes/Decorator.php';
require_once 'includes/MagicProperty.php';

/**
 * This class acts as a wrapper for the actual Object implementation.
 */
class Object extends Decorator implements AbstractObject {

  /**
   * The decorator class to wrap existing datastreams.
   * @var string
   */
  protected $datastreamDecorator = 'Tuque\Datastream';

  /**
   * The decorator class to wrap new not yet ingested datastreams.
   * @var string
   */
  protected $newDatastreamDecorator = 'Tuque\NewDatastream';

  /**
   * The decorator class to wrap the RelsExt implementation.
   *
   * @todo The concept of external vs internal relationships bleeds out. We
   * should address this in the future.
   *
   * @var string
   */
  protected $relsExtDecorator = 'Tuque\RelsExt';

  /**
   * Constructor for the Repository object.
   *
   * @param AbstractObject $object
   *   The object implementation that this class is to decorate.
   */
  public function __construct(AbstractObject $object) {
    parent::__construct($object);
  }

  /**
   * Set the state of the object to deleted.
   *
   * @see AbstractObject::delete
   */
  public function delete() {
    parent::delete();
  }

  /**
   * Get a datastream from the object and decorate it.
   *
   * @see AbstractObject::getDatastream
   */
  public function getDatastream($id) {
    $datastream = parent::getDatastream($id);
    return new $this->datastreamDecorator($datastream);
  }

  /**
   * Purges a datastream.
   *
   * @see AbstractObject::purgeDatastream
   */
  public function purgeDatastream($id) {
    return parent::purgeDatastream($id);
  }

  /**
   * Construct a new datastream and decorate it.
   *
   * @see AbstractObject::getDatastream
   */
  public function constructDatastream($id, $control_group = 'M') {
    $datastream = parent::constructDatastream($id, $control_group);
    return new $this->newDatastreamDecorator($datastream);
  }

  /**
   * Ingests a datastream object into the repository and decorate it.
   *
   * @see AbstractObject::getDatastream
   */
  public function ingestDatastream(&$ds) {
    $datastream = parent::ingestDatastream($ds);
    return new $this->datastreamDecorator($datastream);
  }

  /**
   * @see Countable::count
   */
  public function count() {
    return parent::count();
  }

  /**
   * @see ArrayAccess::offsetExists
   */
  public function offsetExists($offset) {
    return parent::offsetExists($offset);
  }

  /**
   * @see ArrayAccess::offsetGet
   */
  public function offsetGet($offset) {
    return parent::offsetGet($offset);
  }

  /**
   * @see ArrayAccess::offsetSet
   */
  public function offsetSet($offset, $value) {
    return parent::offsetSet($offset, $value);
  }

  /**
   * @see ArrayAccess::offsetUnset
   */
  public function offsetUnset($offset) {
    return parent::offsetUnset($offset);
  }

  /**
   * IteratorAggregate::getIterator()
   */
  public function getIterator() {
    return parent::getIterator();
  }
}

/**
 * This class acts as a wrapper for a new Object implementation.
 */
class NewObject extends Object {

  /**
   * Constructor for the Repository object.
   *
   * @param AbstractObject $object
   *   The object implementation that this class is to decorate.
   */
  public function __construct(AbstractObject $object) {
    parent::__construct($object);
    // No datastream's exist yet so they are all New Datastreams.
    $this->datastreamDecorator = $this->newDatastreamDecorator;
  }

}
