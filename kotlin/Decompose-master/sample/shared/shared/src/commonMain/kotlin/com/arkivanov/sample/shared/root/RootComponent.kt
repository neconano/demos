package com.arkivanov.sample.shared.root

import com.arkivanov.decompose.router.stack.ChildStack
import com.arkivanov.decompose.value.Value
import com.arkivanov.sample.shared.cards.CardsComponent
import com.arkivanov.sample.shared.counters.CountersComponent
import com.arkivanov.sample.shared.customnavigation.CustomNavigationComponent
import com.arkivanov.sample.shared.dynamicfeatures.DynamicFeaturesComponent
import com.arkivanov.sample.shared.multipane.MultiPaneComponent

interface RootComponent {

    val childStack: Value<ChildStack<*, Child>>

    fun onCountersTabClicked()
    fun onCardsTabClicked()
    fun onMultiPaneTabClicked()
    fun onDynamicFeaturesTabClicked()
    fun onCustomNavigationTabClicked()

    sealed class Child {
        class CountersChild(val component: CountersComponent) : Child()
        class CardsChild(val component: CardsComponent) : Child()
        class MultiPaneChild(val component: MultiPaneComponent) : Child()
        class DynamicFeaturesChild(val component: DynamicFeaturesComponent) : Child()
        class CustomNavigationChild(val component: CustomNavigationComponent) : Child()
    }
}
