<?php
/**
 * @see       https://github.com/zendframework/ZendService_Amazon for the canonical source repository
 * @copyright Copyright (c) 2005-2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/ZendService_Amazon/blob/master/LICENSE.md New BSD License
 */

namespace ZendServiceTest\Amazon\Ec2;

use PHPUnit\Framework\TestCase;
use ZendService\Amazon\Ec2;
use Zend\Http\Client as HttpClient;
use Zend\Http\Client\Adapter\Test as HttpClientTestAdapter;

/**
 * Zend_Service_Amazon_Ec2_Elasticip test case.
 *
 * @category   Zend
 * @package    Zend_Service_Amazon
 * @subpackage UnitTests
 * @group      Zend_Service
 * @group      Zend_Service_Amazon
 * @group      Zend_Service_Amazon_Ec2
 */
class ElasticIpTest extends TestCase
{

    /**
     * @var \ZendService\Amazon\Ec2\Elasticip
     */
    protected $elasticip;

    /**
     * @var HttpClient
     */
    protected $httpClient = null;

    /**
     * @var HttpClientTestAdapter
     */
    protected $httpClientTestAdapter = null;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->httpClientTestAdapter = new HttpClientTestAdapter;
        $this->httpClient = new HttpClient(null, ['adapter' => $this->httpClientTestAdapter]);
        $this->elasticip = new Ec2\ElasticIp('access_key', 'secret_access_key', null, $this->httpClient);
    }

    public function testAllocateNewElasticIp()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<AllocateAddressResponse xmlns=\"http://ec2.amazonaws.com/doc/2009-04-04/\">\r\n"
                    . "  <publicIp>67.202.55.255</publicIp>\r\n"
                    . "</AllocateAddressResponse>";
        $this->httpClientTestAdapter->setResponse($rawHttpResponse);

        $ipAddress = $this->elasticip->allocate();
        $this->assertEquals('67.202.55.255', $ipAddress);
    }

    public function testAssociateElasticIpWithInstanceReturnsTrue()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<AssociateAddressResponse xmlns=\"http://ec2.amazonaws.com/doc/2009-04-04/\">\r\n"
                    . "  <return>true</return>\r\n"
                    . "</AssociateAddressResponse>";
        $this->httpClientTestAdapter->setResponse($rawHttpResponse);

        $return = $this->elasticip->associate('67.202.55.255', 'i-ag8ga0a');

        $this->assertTrue($return);
    }

    /**
     * Tests Zend_Service_Amazon_Ec2_Elasticip->describe()
     */
    public function testDescribeSingleElasticIp()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<DescribeAddressesResponse xmlns=\"http://ec2.amazonaws.com/doc/2009-04-04/\">\r\n"
                    . "  <addressSet>\r\n"
                    . "    <item>\r\n"
                    . "      <publicIp>67.202.55.255</publicIp>\r\n"
                    . "      <instanceId>i-ag8ga0a</instanceId>\r\n"
                    . "    </item>\r\n"
                    . "  </addressSet>\r\n"
                    . "</DescribeAddressesResponse>";
        $this->httpClientTestAdapter->setResponse($rawHttpResponse);

        $response = $this->elasticip->describe('67.202.55.255');

        $arrIp = [
            'publicIp'      => '67.202.55.255',
            'instanceId'    => 'i-ag8ga0a'
        ];

        $this->assertSame($arrIp, $response[0]);
    }

    public function testDescribeMultipleElasticIp()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<DescribeAddressesResponse xmlns=\"http://ec2.amazonaws.com/doc/2009-04-04/\">\r\n"
                    . "  <addressSet>\r\n"
                    . "    <item>\r\n"
                    . "      <publicIp>67.202.55.255</publicIp>\r\n"
                    . "      <instanceId>i-ag8ga0a</instanceId>\r\n"
                    . "    </item>\r\n"
                    . "    <item>\r\n"
                    . "      <publicIp>67.202.55.200</publicIp>\r\n"
                    . "      <instanceId>i-aauoi9g</instanceId>\r\n"
                    . "    </item>\r\n"
                    . "  </addressSet>\r\n"
                    . "</DescribeAddressesResponse>";
        $this->httpClientTestAdapter->setResponse($rawHttpResponse);

        $response = $this->elasticip->describe(['67.202.55.255', '67.202.55.200']);

        $arrIps = [
            [
                'publicIp'      => '67.202.55.255',
                'instanceId'    => 'i-ag8ga0a'
            ],
            [
                'publicIp'      => '67.202.55.200',
                'instanceId'    => 'i-aauoi9g'
            ]
        ];

        foreach ($response as $k => $r) {
            $this->assertSame($arrIps[$k], $r);
        }
    }

    /**
     * Tests Zend_Service_Amazon_Ec2_Elasticip->disassocate()
     */
    public function testDisassocateElasticIpFromInstance()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<DisassociateAddressResponse xmlns=\"http://ec2.amazonaws.com/doc/2009-04-04/\">\r\n"
                    . "  <return>true</return>\r\n"
                    . "</DisassociateAddressResponse>";
        $this->httpClientTestAdapter->setResponse($rawHttpResponse);

        $return = $this->elasticip->disassocate('67.202.55.255');

        $this->assertTrue($return);
    }

    /**
     * Tests Zend_Service_Amazon_Ec2_Elasticip->release()
     */
    public function testReleaseElasticIp()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<ReleaseAddressResponse xmlns=\"http://ec2.amazonaws.com/doc/2009-04-04/\">\r\n"
                    . "  <return>true</return>\r\n"
                    . "</ReleaseAddressResponse>";
        $this->httpClientTestAdapter->setResponse($rawHttpResponse);

        $return = $this->elasticip->release('67.202.55.255');

        $this->assertTrue($return);
    }
}
