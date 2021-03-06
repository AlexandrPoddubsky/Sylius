<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\Attribute\AttributeType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Attribute\AttributeType\AttributeTypeInterface;
use Sylius\Component\Attribute\Model\AttributeInterface;
use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class TextAttributeTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Attribute\AttributeType\TextAttributeType');
    }

    function it_implements_attribute_type_interface()
    {
        $this->shouldImplement(AttributeTypeInterface::class);
    }

    function its_storage_type_is_text()
    {
        $this->getStorageType()->shouldReturn('text');
    }

    function its_type_is_text()
    {
        $this->getType()->shouldReturn('text');
    }

    function it_checks_if_attribute_value_is_valid(
        AttributeInterface $attribute,
        AttributeValueInterface $attributeValue,
        ConstraintViolationBuilderInterface $constraintViolationBuilder,
        ConstraintViolationInterface $constraintViolation,
        ConstraintViolationListInterface $constraintViolationList,
        ExecutionContextInterface $context,
        ValidatorInterface $validator
    ) {
        $attributeValue->getAttribute()->willReturn($attribute);

        $attributeValue->getValue()->willReturn('X');

        $context->getValidator()->willReturn($validator);
        $validator->validate('X', Argument::type(Length::class))->willReturn($constraintViolationList);

        $constraintViolationList->rewind()->shouldBeCalled();
        $constraintViolationList->valid()->willReturn(true, false);
        $constraintViolationList->current()->willReturn($constraintViolation);
        $constraintViolationList->next()->shouldBeCalled();

        $constraintViolation->getMessage()->willReturn('error message');

        $context->buildViolation('error message')->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder->atPath('value')->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $this->validate($attributeValue, $context, ['min' => 2, 'max' => 255]);
    }
}
