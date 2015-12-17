<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2016
 * @version   OXID eShop CE
 */

require_once getShopBasePath() . '/Setup/oxsetup.php';

/**
 * dispatcher tests
 */
class Unit_Setup_oxSetupDispatcherTest extends OxidTestCase
{

    /**
     * Testing dispatcher::run()
     *
     * @return null
     */
    public function testRun()
    {
        $oView = $this->getMock("view", array("display"));
        $oView->expects($this->once())->method("display");

        $oController = $this->getMock("controller", array("getView", "testAction"));
        $oController->expects($this->once())->method("getView")->will($this->returnValue($oView));
        $oController->expects($this->once())->method("testAction");

        $oDispatcher = $this->getMock("dispatcher", array("_chooseCurrentAction", "getInstance"));
        $oDispatcher->expects($this->once())->method("_chooseCurrentAction")->will($this->returnValue("testAction"));
        $oDispatcher->expects($this->once())->method("getInstance")->with($this->equalTo("controller"))->will($this->returnValue($oController));
        $oDispatcher->run();
    }

    /**
     * Testing dispatcher::_chooseCurrentAction()
     *
     * @return null
     */
    public function testChooseCurrentAction()
    {
        $oSetup = $this->getMock("oxSetup", array("getCurrentStep", "getSteps"));
        $oSetup->expects($this->once())->method("getCurrentStep")->will($this->returnValue(1));
        $oSetup->expects($this->once())->method("getSteps")->will($this->returnValue(array("step1" => 0, "step2" => 1)));

        $oDispatcher = $this->getMock("dispatcher", array("getInstance"));
        $oDispatcher->expects($this->once())->method("getInstance")->with($this->equalTo("oxSetup"))->will($this->returnValue($oSetup));
        $this->assertEquals("step2", $oDispatcher->UNITchooseCurrentAction());
    }
}
