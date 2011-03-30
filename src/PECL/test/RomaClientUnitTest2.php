<?php
require_once 'RomaClient.php';

/**
 * Test class for RomaClient.
 * Generated by PHPUnit on 2010-08-05 at 16:37:31.
 */
class RomaClientUnitTest2 extends PHPUnit_Framework_TestCase
{

  protected $roma_client;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   *
   * @access protected
   */
  protected function setUp(){
    $this->roma_client = RomaClient::getInstance(array("localhost_11211","localhost_11212"));
    $ret = $this->roma_client->alist_sized_insert("alist-key", 3,"aaa");
    $ret = $this->roma_client->alist_sized_insert("alist-key", 3,"bbb");
    $ret = $this->roma_client->alist_sized_insert("alist-key", 3,"ccc");
  }
  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   *
   * @access protected
   */
  protected function tearDown(){
      
  }

  /**
   * No.
   * No.
   */
  public function testSetKeyNull() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    try {
      $ret = $this->roma_client->set(NULL, "bar", 0);
      $this->assertTrue(false,"should throw!");
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
      throw $e;
    } catch (Exception $e) {
    }
  }
  /**
   * No.
   * No.
   */
  public function testSetValNull() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    $ret = $this->roma_client->set("foo", NULL, 0);
    $this->assertTrue($ret);
  }
  /**
   * No.
   * No.
   */
  public function testSetKeyEmpty() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    try {
      $ret = $this->roma_client->set("", "bar", 0);
      $this->assertTrue(false,"should throw!");
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
      throw $e;
    } catch (Exception $e) {
    }
  }
  /**
   * No.
   * No.
   */
  public function testSetValEmpty() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    $ret = $this->roma_client->set("foo", NULL, 0);
    $this->assertTrue($ret);
  }
  /**
   * No.
   * No.
   */
  public function testGetKeyNull() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    try {
      $ret = $this->roma_client->get(NULL);
      $this->assertTrue(false,"should throw!");
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
      throw $e;
    } catch (Exception $e) {
    }
  }
  /**
   * No.
   * No.
   */
  public function testGetKeyEmpty() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    try {
      $ret = $this->roma_client->get("");
      $this->assertTrue(false,"should throw!");
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
      throw $e;
    } catch (Exception $e) {
    }
  }

  /**
   * No.
   * No.
   */
  public function testAlistSizedInsertKeyNull() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    try {
      $ret = $this->roma_client->alist_sized_insert(NULL, 10,"alist-value");
      $this->assertTrue(false,"should throw!");
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
      throw $e;
    } catch (Exception $e) {
    }
  }
  /**
   * No.
   * No.
   */
  public function testAlistSizedInsertValNull() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    $ret = $this->roma_client->alist_sized_insert("alist-key",10, NULL);
    $this->assertTrue($ret);
  }
  /**
   * No.
   * No.
   */
  public function testAlistSizedInsertKeyEmpty() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    try {
      $ret = $this->roma_client->alist_sized_insert("", 10 ,"alist-value");
      $this->assertTrue(false,"should throw!");
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
      throw $e;
    } catch (Exception $e) {
    }
  }
  /**
   * No.
   * No.
   */
  public function testAlistSizedInsertValEmpty() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    $ret = $this->roma_client->alist_sized_insert("alist-key", 10 , NULL);
    $this->assertTrue($ret);
  }
  /**
   * No.
   * No.
   */
  public function testAlistSizedInsertSizeZero() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    $ret = $this->roma_client->alist_sized_insert("alist-key", 0 , "alist-value");
    $this->assertTrue($ret);
  }
  /**
   * No.
   * No.
   */
  public function testAlistSizedInsertSizeNegative() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    $ret = $this->roma_client->alist_sized_insert("alist-key", -1 , "alist-value");
    $this->assertTrue($ret);
  }
  /**
   * No.
   * No.
   */
  public function testAlistJoinKeyNull() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    try {
      $ret = $this->roma_client->alist_join(NULL,"|");
      $this->assertTrue(false,"should throw!");
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
      throw $e;
    } catch (Exception $e) {
    }
  }
  /**
   * No.
   * No.
   */
  public function testAlistJoinSepNull() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    try {
      $val = $this->roma_client->alist_join("alist-key",NULL);
      $this->assertEquals("cccbbbaaa",implode('+',$val));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
      throw $e;
    } catch (Exception $e) {
    }
  }
  /**
   * No.
   * No.
   */
  public function testAlistJoinNotfound() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    $val = $this->roma_client->alist_join("NOT_FOUND", "|");
    $this->assertEquals(NULL,$val);
  }
  /**
   * No.
   * No.
   */
  public function testAlistJoinSeqEmpty() {
    print "\n***TEST*** ". get_class($this) ."::". __FUNCTION__ . "\n";
    $val = $this->roma_client->alist_join("alist-key", "");
    $this->assertEquals("cccbbbaaa",implode('+',$val));
  }
}

?>
