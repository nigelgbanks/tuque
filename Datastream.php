<?php

/**
 * @file
 * Wrapper class for the Repository Object class implementation.
 *
 * @todo Make the AbstractDatastream an interface rather than a class.
 */

namespace Tuque;
use \AbstractDatastream as AbstractDatastream;

require_once 'AbstractDatastream.php';
require_once 'includes/Decorator.php';
require_once 'includes/MagicProperty.php';

/**
 * Wrapper for the implementation of the datastream class.
 */
class Datastream extends Decorator implements AbstractDatastream {

  /**
   * The decorator class to wrap the RelsExt implementation.
   *
   * @todo The concept of external vs internal relationships bleeds out. We
   * should address this in the future.
   *
   * @var string
   */
  protected $relsIntDecorator = 'Tuque\Decorator';

  /**
   * The decorator class to wrap previous datastream versions.
   * @var string
   */
  protected $datastreamVersionDecorator = 'Tuque\Decorator';

  /**
   * Constructor for the Repository Object Datastream.
   *
   * @param AbstractDatastream $datastream
   *   The datastream implementation that this class is to decorate.
   */
  public function __construct(AbstractDatastream $datastream) {
    parent::__construct($datastream);
    $this->relationships = new $this->relsIntDecorator($this->relationships);
  }

  /**
   * Get a datastream version from the object and decorate it.
   *
   * @see AbstractDatastream::getDatastreamVersion
   */
  public function getDatastreamVersion(array $datastream_info) {
    $version = parent::getDatastreamVersion($datastream_info);
    return new $this->datastreamVersionDecorator($version);
  }

  /**
   * This will set the state of the datastream to deleted.
   *
   * @see AbstractDatastream::delete
   */
  public function delete() {
    return parent::delete();
  }

  /**
   * Set the contents of the datastream from a file.
   *
   * @see AbstractDatastream::setContentFromFile
   */
  public function setContentFromFile($file) {
    return parent::setContentFromFile($file);
  }

  /**
   * Set the contents of the datastream from a URL.
   *
   * @see AbstractDatastream::setContentFromFile
   */
  public function setContentFromUrl($url) {
    return parent::setContentFromUrl($url);
  }

  /**
   * Set the contents of the datastream from a string.
   *
   * @see AbstractDatastream::setContentFromString
   */
  public function setContentFromString($string) {
    return parent::setContentFromString($string);
  }

  /**
   * Get the contents of a datastream and output it to the file provided.
   *
   * @see AbstractDatastream::getContent
   */
  public function getContent($file) {
    return parent::getContent($file);
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
 * Wrapper for the implementation of the datastream class.
 *
 * For now just decorate in the same way that Datastream does.
 */
class NewDatastream extends Datastream {
}
