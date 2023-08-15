package com.arkivanov.sample.shared.cards

import com.arkivanov.decompose.ComponentContext
import com.arkivanov.decompose.router.stack.ChildStack
import com.arkivanov.decompose.router.stack.StackNavigation
import com.arkivanov.decompose.router.stack.childStack
import com.arkivanov.decompose.router.stack.items
import com.arkivanov.decompose.router.stack.navigate
import com.arkivanov.decompose.router.stack.pop
import com.arkivanov.decompose.router.stack.push
import com.arkivanov.decompose.value.Value
import com.arkivanov.essenty.parcelable.Parcelable
import com.arkivanov.essenty.parcelable.Parcelize
import com.arkivanov.sample.shared.cards.card.CardComponent
import com.arkivanov.sample.shared.cards.card.DefaultCardComponent

class DefaultCardsComponent(
    componentContext: ComponentContext,
) : CardsComponent, ComponentContext by componentContext {

    private val navigation = StackNavigation<Config>()

    private val _stack: Value<ChildStack<Config, CardComponent>> =
        childStack(
            source = navigation,
            initialStack = {
                COLORS.mapIndexed { index, color ->
                    Config(color = color, number = index + 1)
                }
            },
            childFactory = ::card,
        )

    override val stack: Value<ChildStack<*, CardComponent>> = _stack

    private fun card(config: Config, componentContext: ComponentContext): CardComponent =
        DefaultCardComponent(
            componentContext = componentContext,
            color = config.color,
            number = config.number,
        )

    override fun onCardSwiped(index: Int) {
        navigation.navigate { stack ->
            val config = stack[index]
            listOf(config) + (stack - config)
        }
    }

    override fun onAddClicked() {
        if (_stack.items.size >= 10) {
            return
        }

        val maxNumber = _stack.items.maxOf { it.configuration.number }

        navigation.push(
            Config(
                color = COLORS[maxNumber % COLORS.size],
                number = maxNumber + 1,
            )
        )
    }

    override fun onRemoveClicked() {
        navigation.pop()
    }

    private companion object {
        private val COLORS =
            listOf(
                0xFF2980B9,
                0xFFE74C3C,
                0xFF27AE60,
                0xFFF39C12,
            )
    }

    @Parcelize
    private data class Config(
        val color: Long,
        val number: Int,
    ) : Parcelable
}
