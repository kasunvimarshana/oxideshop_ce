<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Form\ContactForm;

use OxidEsales\EshopCommunity\Internal\Common\Form\Form;
use OxidEsales\EshopCommunity\Internal\Common\Form\FieldConfiguration;
use OxidEsales\EshopCommunity\Internal\Form\ContactForm\ContactFormEmailValidator;
use OxidEsales\EshopCommunity\Internal\Adapter\ShopAdapter;

class ContactFormEmailValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidEmailValidation()
    {
        $validator = $this->getContactFormEmailValidator();

        $invalidEmailField = new FieldConfiguration();
        $invalidEmailField->setName('email');
        $invalidEmailField->setValue('ImSoInvalid');

        $form = new Form();
        $form->add($invalidEmailField);

        $this->assertFalse(
            $validator->isValid($form)
        );

        $this->assertSame(
            ['ERROR_MESSAGE_INPUT_NOVALIDEMAIL'],
            $validator->getErrors()
        );
    }

    public function testValidEmailValidation()
    {
        $validator = $this->getContactFormEmailValidator();

        $validEmailField = new FieldConfiguration();
        $validEmailField->setName('email');
        $validEmailField->setValue('someemail@validEmailsClub.com');

        $form = new Form();
        $form->add($validEmailField);

        $this->assertTrue(
            $validator->isValid($form)
        );
    }

    private function getContactFormEmailValidator()
    {
        return new ContactFormEmailValidator(
            new ShopAdapter()
        );
    }
}
