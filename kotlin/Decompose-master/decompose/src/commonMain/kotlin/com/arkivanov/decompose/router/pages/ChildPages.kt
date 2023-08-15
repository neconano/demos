package com.arkivanov.decompose.router.pages

import com.arkivanov.decompose.Child
import com.arkivanov.decompose.ExperimentalDecomposeApi

/**
 * A state holder for Child Pages.
 *
 * @param items a list of child components.
 * @param selectedIndex an index of the selected child component.
 * Must be within the range of [items] indices if [items] is not empty, otherwise can be any number.
 */
@ExperimentalDecomposeApi
data class ChildPages<out C : Any, out T : Any>(
    val items: List<Child<C, T>>,
    val selectedIndex: Int,
) {

    /**
     * Creates empty [ChildPages].
     */
    constructor() : this(items = emptyList(), selectedIndex = -1)

    init {
        if (items.isNotEmpty()) {
            require(selectedIndex in items.indices)
        }
    }
}
