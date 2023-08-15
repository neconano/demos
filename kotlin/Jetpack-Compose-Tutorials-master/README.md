### Jetpack Compose Tutorials and Playground

## 🤓 Overview

Series of Tutorials to learn about Jetpack Compose, Material Widgets, State, Animation, and
Navigation. Easy to search in code and in app. Each chapter module contains its own content in code.
SearchBar can be used to search with a tag or description available for each tutorial.

Recommended section is under constructions for now, when finished it will get recommended tags using
previous searches using a database, domain with ViewModel.

<br>
<div align="center">
<img src="/./screenshots/intro.gif" align="center" width="32%"/>
</div>

<br><br><br>

| Tutorial                                                                                                                                                                                                                     | Preview                                               |
|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------|
| <h3>1-1 Column, Row, Box, Modifiers</h3><br/>Create Row that adds elements in horizontal order, and Column that adds elements in vertical order.<br><br> • Column<br>• Row<br>• Box<br>• Modifier<br>                        | <img src ="/./screenshots/tutorial1_1.jpg" width=200> |
|                                                                                                                                                                                                                              |                                                       |
| <h3>1-2 Surface, Shape, Clickable</h3><br/>Create and modify Surface to draw background for Composables, add click action to any composable. Set weight or offset modifiers.<br><br> • Surface<br>• Shape<br>• Clickable<br> | <img src ="/./screenshots/tutorial1_2.jpg" width=200> |
|                                                                                                                                                                                                                              |                                                       |

### Material Widgets

| Tutorial                                                                                                                                                                                                                                                                                                                                                                                                                           | Preview                                                   |
|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------|
| <h3>2-1 Text</h3><br/>Create Text component with different properties such as color, background, font weight, family, style, spacing and others<br><br> • Text<br>• Row<br>• FontStyle<br>• Annotated String Hyperlink<br>                                                                                                                                                                                                         | <img src ="/./screenshots/tutorial2_1.jpg" width=200>     |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-2 Button, IconButton, FAB, Chip</h3><br/>Create button with text and/or with image, Floating Action Button  or Chips. Modify properties of buttons including color, text, and click actions.<br><br> • Button<br>• IconButton<br>• FloatingActionButton<br>• Chip<br>                                                                                                                                                        | <img src ="/./screenshots/tutorial2_2.jpg" width=200>     |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-3 TextField</h3><br/>Create TextField component with regular style or outlined. Set error, colors, state, icons, and IME actions.<br><br> • TextField<br>• OutlinedTextField<br>• IME<br>• Phone format VisualTransformation<br>• Regex<br>                                                                                                                                                                                  | <img src ="/./screenshots/tutorial2_3.jpg" width=200>     |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-4 Image</h3><br/>Create Image with image, vector resource or with Painter, set image and Content scales to fit, expand or shrink image. Change shape of Image or apply ColorFilter and PorterDuff modes.<br><br> • Image<br>• Canvas<br>• Drawable<br>• Bitmap<br>                                                                                                                                                           | <img src ="/./screenshots/tutorial2_4.gif" width=200>     |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-5 LazyColumn/Row/VerticalGrid</h3><br/>Vertical, horizontal grid lists with LazyColumn, LazyRow and LazyVerticalGrid. Use contentPadding set paddings for lists, verticalArrangement or horizontalArrangement for padding between items, rememberLazyListState to manually scroll.<br><br> • LazyColumn(Vertical RecyclerView)<br>• LazyRow(Horizontal RecyclerView<br>• LazyVerticalGrid(GridLayout)<br>• StickyHeaders<br> | <img src ="/./screenshots/tutorial2_5.gif" width=200>     |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-6 TopAppbar & Tab</h3><br/>TopAppbar with actions, overflow menus. Tabs with text only, image only and image+text with different background, divider, and indicators.<br><br> • TopAppBar<br>• Overflow menu<br>• TabRow and Tab<br>• Tab Indicator, Divider<br>                                                                                                                                                             | <img src ="/./screenshots/tutorial2_6.gif" width=200>     |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-7 BottomNavigation</h3><br/>Bottom navigation bars allow movement between primary destinations in an app. BottomNavigation should contain multiple BottomNavigationItems, each representing a singular destination.<br><br> • BottomNavigation<br>• BottomNavigationItem<br>                                                                                                                                                 | <img src ="/./screenshots/tutorial2_7.jpeg" width=200>    |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-8 BottomAppBar</h3><br/>A bottom app bar displays navigation and key actions at the bottom of screens.<br><br> • BottomAppBar<br>• Scaffold<br>                                                                                                                                                                                                                                                                              | <img src ="/./screenshots/tutorial2_8.jpeg" width=200>    |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-9-1 Side Navigation</h3><br/>A backdrop appears behind all other surfaces in an app, displaying contextual and actionable content.<br><br> • Scaffold<br>• Side Navigation<br>• DrawerState<br>                                                                                                                                                                                                                              | <img src ="/./screenshots/tutorial2_9.jpeg" width=200>    |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-9-2 ModalDrawer</h3><br/>Modal navigation drawers block interaction with the rest of an app’s content with a scrim. They are elevated above most of the app’s UI and don’t affect the screen’s layout grid.<br><br> • ModalDrawer<br>• DrawerState<br>• Scaffold<br>                                                                                                                                                         | <img src ="/./screenshots/tutorial2_9_2.jpeg" width=200>  |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-10-1 BottomSheet</h3><br/>Create bottom sheet using BottomSheetScaffold and rememberBottomSheetScaffoldState, create modal bottom sheets.<br><br> • BottomSheetScaffold<br>• BottomSheetState<br>• ModalBottomSheetLayout<br>                                                                                                                                                                                                | <img src ="/./screenshots/tutorial2_10.jpeg" width=200>   |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-10-4 BottomDrawer</h3><br/>BottomDrawer with BottomAppBar.<br><br> • BottomDrawer<br>• BottomAppBar<br>• Scaffold<br>                                                                                                                                                                                                                                                                                                        | <img src ="/./screenshots/tutorial2_10_4.jpeg" width=200> |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-10-5 BackdropScaffold</h3><br/>BackdropScaffold provides an API to put together several material components to construct your screen.<br>                                                                                                                                                                                                                                                                                    | <img src ="/./screenshots/tutorial2_10_5.jpeg" width=200> |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-11 Snackbar, Progress, Selection</h3><br/>Create Snackbars with various layouts and styling, Checkboxes with selectable text, tri state checkbox, grouped radio buttons and sliders.<br><br> • SnackBar<br>• ProgressIndicator<br>• Checkbox<br>• TriStateCheckbox<br>• Switch<br>• RadioButton<br>• Slider<br>• RangeSlider<br>                                                                                             | <img src ="/./screenshots/tutorial2_11.gif" width=200>    |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |
| <h3>2-12 Dialog, AlertDialog</h3><br/>Create Dialog, and AlertDialog with standard and custom layouts. Implement on dismiss logic and get result when dialog is closed.<br><br>• AlertDialog<br>• Dialog<br>• DialogProperties<br>                                                                                                                                                                                                 | <img src ="/./screenshots/tutorial2_12.gif" width=200>    |
|                                                                                                                                                                                                                                                                                                                                                                                                                                    |                                                           |

### Layout

| Tutorial                                                                                                                                                                                                                                                                                                                                 | Preview                                                 |
|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------|
| <h3>3-1-1 Custom Modifier</h3><br/>Create custom layout using using layout, Measurable, Constraint, Placeable.<br><br>• Custom Modifier<br>• Measurable<br>• Constraint<br>• Placeable<br>                                                                                                                                               | <img src ="/./screenshots/tutorial3_1_1.png" width=200> |
|                                                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>3-1-3 graphicsLayer</h3><br/>Use Modifier.offset{} and Modifier.graphicsLayer{} to scale, translate or change other properties of a Composable.<br><br>• Modifier<br>• graphicsLayer<br>                                                                                                                                             | <img src ="/./screenshots/tutorial3_1_3.gif" width=200> |
|                                                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>3-2-1 Custom Layout</h3><br/>Create custom layout using using MeasurePolicy and use intrinsic dimensions.<br><br>• Custom Layout<br>• Measurable<br>• Constraint<br>• Placeable<br>                                                                                                                                                  | <img src ="/./screenshots/tutorial3_2_1.png" width=200> |
|                                                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>3-3-1 Scope&ParentDataModifier</h3><br/>Add custom modifiers to Composable inside a custom layout using its scope like align modifier only available in specific Composable like a custom Column.<br><br>• Custom Layout<br>• Scope<br>• ParentDataModifier<br>• Measurable<br>• Constraint<br>• Placeable<br>                       | <img src ="/./screenshots/tutorial3_3_1.png" width=200> |
|                                                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>3-4 BoxWithConstraints</h3><br/>BoxWithConstraints is a composable that defines its own content according to the available space, based on the incoming constraints or the current LayoutDirection.<br><br>• BoxWithConstraints<br>• Constraint<br>                                                                                  | <img src ="/./screenshots/tutorial3_4.png" width=200>   |
|                                                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>3-5 SubcomposeLayout</h3><br/>Subcompose layout which allows to subcompose the actual content during the measuring stage for example to use the values calculated during the measurement as params for the composition of the children.<br><br>• SubcomposeLayout<br>• Constraint<br>• Measurable<br>• Constraint<br>• Placeable<br> | <img src ="/./screenshots/tutorial3_5.gif" width=200>   |
|                                                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>3-6-1 Custom Chat Layouts1</h3><br/>Custom layout like whatsapp chat layout that moves time and message read status layout right or bottom based on message width.<br><br>• Custom Layout<br>• Measurable<br>• Constraint<br>• Placeable<br>                                                                                         | <img src ="/./screenshots/tutorial3_6_1.gif" width=200> |
|                                                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>3-6-2 Custom Chat SubcomposeLayout</h3><br/>Custom layout like whatsapp chat. Added quote and name tag resized to longest sibling using SubcomposeColumn from previous examples to have whole layout.<br><br>• Custom Layout<br>• SubcomposeLayout<br>• Measurable<br>• Constraint<br>• Placeable<br>                                | <img src ="/./screenshots/tutorial3_6_2.gif" width=200> |
|                                                                                                                                                                                                                                                                                                                                          |                                                         |

### State

| Tutorial                                                                                                                                                                                                                                                                                                 | Preview                                                 |
|:---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------|
| <h3>4-1-1 Remember&MutableState</h3><br/>Remember and mutableState effect recomposition and states.<br><br>• remember<br>• State<br>• Recomposition<br>                                                                                                                                                  | <img src ="/./screenshots/tutorial4_1_1.png" width=200> |
|                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>4-2-3 Scoped Recomposition</h3><br/>How hierarchy of Composables effects Smart Composition.<br><br>• remember<br>• Recomposition<br>• State<br>                                                                                                                                                      | <img src ="/./screenshots/tutorial4_2_3.png" width=200> |
|                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>4-4 Custom Remember</h3><br/>Create a custom remember and custom component to have badge that changes its shape based on properties set by custom rememberable.<br><br>• remember<br>• State<br>• Recomposition<br>• Custom Layout<br>                                                               | <img src ="/./screenshots/tutorial4_4.gif" width=200>   |
|                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>4-5-1 SideEffect1</h3><br/>Use remember functions like rememberCoroutineScope, and rememberUpdatedState and side-effect functions such as LaunchedEffect and DisposableEffect.<br><br>• remember<br>• rememberCoroutineScope<br>• rememberUpdatedState<br>• LaunchedEffect<br>• DisposableEffect<br> | <img src ="/./screenshots/tutorial4_5_1.png" width=200> |
|                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>4-5-2 SideEffect2</h3><br/>Use SideEffect, derivedStateOf, produceState and snapshotFlow.<br><br>• remember<br>• SideEffect<br>• derivedStateOf<br>• produceStateOf<br>• snapshotFlow<br>                                                                                                            | <img src ="/./screenshots/tutorial4_5_2.png" width=200> |
|                                                                                                                                                                                                                                                                                                          |                                                         |
| <h3>4-7-3 Compose Phases3</h3><br/>How deferring a state read changes which phases of frame(Composition, Layout, Draw) are called.<br><br>• Modifier<br>• Recomposition<br>• Composition<br>• Layout<br>• Draw<br>                                                                                       | <img src ="/./screenshots/tutorial4_7_3.gif" width=200> |
|                                                                                                                                                                                                                                                                                                          |                                                         |

### Gesture

| Tutorial                                                                                                                                                                                                                                                                                                                                                                                                    | Preview                                                  |
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------|
| <h3>5-1-1 Clickable</h3><br/>Use clickable modifier, Indication. Indication to clip ripples, or create custom ripple effects.<br><br>• clickable<br>• Indication<br>• rememberRipple<br>• pointerInput<br>• pointerInteropFilter<br>                                                                                                                                                                        | <img src ="/./screenshots/tutorial5_1_1.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-1-2 InteractionSource1</h3><br/>Use Interaction source to collect interactions or change scale of Composables based on interaction state.<br><br>• clickable<br>• InteractionSource<br>                                                                                                                                                                                                               | <img src ="/./screenshots/tutorial5_2.gif" width=200>    |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-1-3 InteractionSource2</h3><br/>Use InteractionSource to update touch state of multiple Composable or another Composable based on current interaction.<br><br>• clickable<br>• InteractionSource<br>                                                                                                                                                                                                  | <img src ="/./screenshots/tutorial5_1_3.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-2 Tap&Drag Gesture</h3><br/>Use PointerInput to listen press, tap, long press, drag gestures. detectTapGestures is used for listening for tap, longPress, doubleTap, and press gestures.<br><br>• pointerInput<br>• pointerInteropFilter<br>• detectTapGestures<br>• detectDragGestures<br>• onPress<br>• onDoubleTap<br>                                                                             | <img src ="/./screenshots/tutorial5_2.gif" width=200>    |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-3 Transform Gestures</h3><br/>Use PointerInput to listen for detectTransformGesture to get centroid, pan, zoom and rotate params.<br><br>• pointerInput<br>• detectTransformGestures<br>• centroid<br>• pan<br>• zoom<br>                                                                                                                                                                             | <img src ="/./screenshots/tutorial5_3.gif" width=200>    |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-4-1 AwaitPointerEventScope1</h3><br/>Use AwaitPointerEventScope to get awaitFirstDown for down events, waitForUpOrCancellation for up events, and awaitPointerEvent for move events with pointers.<br><br>• AwaitPointerEventScope<br>• PointerInputChange<br>• awaitFirstDown<br>• waitForUpOrCancellation<br>• awaitPointerEvent<br>• awaitTouchSlopOrCancellation<br>• awaitDragOrCancellation<br> | <img src ="/./screenshots/tutorial5_4_1.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-4-3 Centroid, Zoom, Pan, Rotation</h3><br/>Use AwaitPointerEventScope to calculate centroid position and size, zoom, pan, and rotation.<br><br>• AwaitPointerEventScope<br>• centroid<br>• pan<br>• zoom<br>                                                                                                                                                                                          | <img src ="/./screenshots/tutorial5_4_3.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-6-2 Gesture Propagation1</h3><br/>Consume different type of touch events in Composable in an hierarchy to display gesture propagation between parent and children with MOVE gestures.<br><br>• AwaitPointerEventScope<br>• pointerInput<br>• consume<br>• consumePositionChange<br>• anyChangeConsumed<br>                                                                                            | <img src ="/./screenshots/tutorial5_6_2.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-6-4 Transform Propagation</h3><br/>Consume events to rotate, zoom, move or apply drag or move events on Composables.<br>• AwaitPointerEventScope<br>• detectTransformGestures<br>• consume<br>• consumePositionChange<br>• anyChangeConsumed<br>• pan<br>• zoom<br>                                                                                                                                   | <img src ="/./screenshots/tutorial5_6_4.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-9-4 Collapsing TopAppBar</h3><br/>Create a collapsing TopAppBar using Modifier.nestedScroll and NestedScrollConnection.<br>• nestedScroll<br>• NestedScrollConnection<br>                                                                                                                                                                                                                             | <img src ="/./screenshots/tutorial5_9_4.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-10-1 Image Touch Detection</h3><br/>Detect touch position on image and get color at touch position.<br>• Image<br>• AwaitPointerEventScope<br>                                                                                                                                                                                                                                                        | <img src ="/./screenshots/tutorial5_10_1.gif" width=200> |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |
| <h3>5-11 Zoomable LazyColumn</h3><br/>Zoom images inside a LazyColum.<br>• Image<br>• Zoom<br>• AwaitPointerEventScope<br>                                                                                                                                                                                                                                                                                  | <img src ="/./screenshots/tutorial5_11.gif" width=200>   |
|                                                                                                                                                                                                                                                                                                                                                                                                             |                                                          |

### Graphics

| Tutorial                                                                                                                                                                                                                                                                                               | Preview                                                 |
|:-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------|
| <h3>6-1-1 Canvas Basics 1</h3><br/>Use canvas draw basic shapes like line, circle, rectangle, and points with different attributes such as style, stroke cap, brush.<br><br>• Canvas<br>• DrawScope<br>• Path<br>• Path Effect<br>                                                                     | <img src ="/./screenshots/tutorial6_1_1.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-1-2 Canvas Basics 2</h3><br/>Use canvas to draw arc, with path effect, stroke cap, stroke join, miter and other attributes and draw images with src, dst attributes.<br><br>• Canvas<br>• DrawScope<br>• Path<br>• Path Effect<br>                                                               | <img src ="/./screenshots/tutorial6_1_2.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-1-3 Canvas Paths</h3><br/>Use canvas to draw path using absolute and relative positions, adding arc to path, drawing custom paths, progress, polygons, quads, and cubic.<br><br>• Canvas<br>• DrawScope<br>• Path<br>• Path Effect<br>                                                           | <img src ="/./screenshots/tutorial6_1_3.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-1-4 Canvas Path Ops</h3><br/>Use canvas to clip paths, or canvas using path, or rectangle with operations such as Difference, Intersect, Union, Xor, or ReverseDifference..<br><br>• Canvas<br>• DrawScope<br>• Path<br>• PathOperation<br>• ClipOperation<br>                                   | <img src ="/./screenshots/tutorial6_1_4.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-1-5 Canvas Path Segments</h3><br/>Use canvas to flatten Android Path to path segments and display PathSegment start and/or end points.<br><br>• Canvas<br>• DrawScope<br>• Path<br>• PathSegment<br>                                                                                             | <img src ="/./screenshots/tutorial6_1_5.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-1-6 Canvas PathEffect</h3><br/>Use PathEffect such as dashedPathEffect, cornerPathEffect, chainPathEffect and stompedPathEffect to draw shapes add path effects around Composables<br><br>• Canvas<br>• DrawScope<br>• Path<br>• Path Effect<br>                                                 | <img src ="/./screenshots/tutorial6_1_6.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-2-1 Blend(Porter-Duff) Modes</h3><br/>Use blend(Porter-Duff) modes to change drawing source/destination or clip based on blend mode ,and manipulate pixels.<br><br>• Canvas<br>• DrawScope<br>• Path<br>• Path Effect<br>• BlendMode<br>                                                         | <img src ="/./screenshots/tutorial6_2_1.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-2-3 Multi-Color VectorDrawable</h3><br/>Use blend(Porter-Duff) to create multi colored VectorDrawables or VectorDrawables with fill/empty animations<br><br>• Canvas<br>• DrawScope<br>• VectorDrawable<br>• BlendMode<br>                                                                       | <img src ="/./screenshots/tutorial6_2_3.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-4-2 Drawing App</h3><br/>Draw to canvas using touch down, move and up events using array of paths to have erase, undo, redo actions and set properties for each path separately.<br><br>• Canvas<br>• DrawScope<br>• Path<br>• AwaitPointerEventScope<br>• PointerInputChange<br>• BlendMode<br> | <img src ="/./screenshots/tutorial6_4_2.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-5 Color Picker</h3><br/>Color Picker that calculates angle from center and gets a color using hue and returns a color as in HSL or RGB color model.<br><br>• Canvas<br>• DrawScope<br>• Path<br>• AwaitPointerEventScope<br>• PointerInputChange<br>• BlendMode<br>                              | <img src ="/./screenshots/tutorial6_5.gif" width=200>   |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-6 Scale/Translation Edit</h3><br/>Editable Composable that changes position and scale when touched and dragged from handles or changes position when touched inside.<br><br>• Canvas<br>• DrawScope<br>• Scale<br>• Translate<br>• AwaitPointerEventScope<br>• PointerInputChange<br>            | <img src ="/./screenshots/tutorial6_6.gif" width=200>   |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-7 Gooey Effect</h3><br/>Create basic Gooey Effect with static circles and one with moves with touch.<br><br>• Canvas<br>• DrawScope<br>• Gooey<br>• Translate<br>• AwaitPointerEventScope<br>• PointerInputChange<br>                                                                            | <img src ="/./screenshots/tutorial6_7.gif" width=200>   |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-8-1 Cutout Arc Shape</h3><br/>Use Path.cubicTo, Path.arcTo to draw cutout shape.<br><br>• Canvas<br>• Path<br>• Scale<br>                                                                                                                                                                        | <img src ="/./screenshots/tutorial6_8_1.png" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-9-1 Neon Glow Effect</h3><br/>Use paint.asFrameworkPaint() to create blur effect to mimic neon glow <br/>and infinite animation to dim and glow infinitely.<br><br>• Canvas<br>• Path<br>• Neon<br>• AwaitPointerEventScope<br>• PointerInputChange<br>                                          | <img src ="/./screenshots/tutorial6_9_1.gif" width=200> |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-11 Canvas Erase Percentage</h3><br/>Use blend(Porter-Duff) modes with androidx.compose.ui.graphics.Canvas to erase and compare pixels with erased Bitmap to find ou percentage of erased area.<br><br>• ActualCanvas<br>• Path<br>• AwaitPointerEventScope<br>• PointerInputChange<br>           | <img src ="/./screenshots/tutorial6_11.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-12 Diagonal Price Tag</h3><br/>Use Modifier.drawBehind and Modifier.composed to draw diagonal price tag with shimmer effect<br><br>• TextMeasurer<br>• Canvas<br>• Composed<br>• Brush<br>• Image<br>                                                                                            | <img src ="/./screenshots/tutorial6_12.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-13 Border Progress</h3><br/>Use Path segments to create path with progress to display remaining time<br><br>• Canvas<br>• Path<br>• PathSegment<br>                                                                                                                                              | <img src ="/./screenshots/tutorial6_13.gif" width=200>  |
|                                                                                                                                                                                                                                                                                                        |                                                         |
| <h3>6-17 Animated Rainbow Border</h3><br/>Draw animated rainbow color border using BlendMode.SrcIn and Modifier.drawWithCache<br><br>• Canvas<br>• Shape<br>• BlendMode<br>• Brush<br>                                                                                                                 | <img src ="/./screenshots/tutorial6_17.gif" width=200>  |

### Stability, Skippable, Restartable

Add snippet below to app's gradle module
```
subprojects {
    tasks.withType(org.jetbrains.kotlin.gradle.tasks.KotlinCompile).configureEach {
        kotlinOptions {
            if (project.findProperty("composeCompilerReports") == "true") {
                freeCompilerArgs += [
                        "-P",
                        "plugin:androidx.compose.compiler.plugins.kotlin:reportsDestination=" +
                                project.buildDir.absolutePath + "/compose_compiler"
                ]
            }
            if (project.findProperty("composeCompilerMetrics") == "true") {
                freeCompilerArgs += [
                        "-P",
                        "plugin:androidx.compose.compiler.plugins.kotlin:metricsDestination=" +
                                project.buildDir.absolutePath + "/compose_compiler"
                ]
            }
        }
    }
}
```

And run task to check for compiler reports for stability inside **build/compiler_reports**

```./gradlew assembleRelease -PcomposeCompilerReports=true```

### Some of the answers i posted on Stackoverflow

#### Composable Functions, Recomposition

[Difference Between Composable and Normal Functions](https://stackoverflow.com/questions/73220189/what-are-differents-between-composable-function-and-normal-function-in-android/73261429#73261429)<br>
[What does Jetpack Compose remember actually do, how does it work under the hood?](https://stackoverflow.com/a/69961175/5457853)<br>
[Scoped/Smart Recomposition](https://stackoverflow.com/a/71016788/5457853)<br>
[Why does mutableStateOf without remember work sometimes?](https://stackoverflow.com/a/71047185/5457853)<br>
[Lambdas, Scopes, and Recomposition](https://stackoverflow.com/a/73681007/5457853)<br>
[MutableState vs MutableStateFlow](https://stackoverflow.com/a/70217911/5457853)<br>
[Destructuring MutableState](https://stackoverflow.com/a/71970915/5457853)<br>
[Does a 0dp sized composable even get composed](https://stackoverflow.com/questions/73179090/does-a-0dp-sized-composable-even-get-composed/73181512#73181512)<br>
[** Jetpack Compose - Recomposition ignoring function parameter](https://stackoverflow.com/a/73610519/5457853)<br>
[Unable to call @Composable function from remember block](https://stackoverflow.com/a/74363923/5457853)<br>
[Composable doesn't re-compose on button click](https://stackoverflow.com/a/74588794/5457853)<br>
[Jetpack Compose - avoid unnecessary recomposition](https://stackoverflow.com/a/74363723/5457853)<br>
[In compose, why modify the properties of the List element, LazyColumn does not refresh](https://stackoverflow.com/a/74506067/5457853)<br>

#### Composables

[How to get exact size without recomposition?](https://stackoverflow.com/a/73357119/5457853)<br>
[When should I use Android Jetpack Compose Surface composable?](https://stackoverflow.com/a/73030914/5457853)<br>
[How can I select only 3 element in a grid/list (jetpack compose)?](https://stackoverflow.com/a/73501341/5457853)<br>
[Android Compose: Difference between LazyColumn and Column with verticalScroll](https://stackoverflow.com/a/73735069/5457853)<br>
[Remove default padding from CheckBox](https://stackoverflow.com/a/71609165/5457853)<br>
[How to give different color to textDecoration?](https://stackoverflow.com/a/73570822/5457853)<br>
[Jetpack compose custom snackbar material 3](https://stackoverflow.com/a/73369351/5457853)<br>
[How to place hanging icon in upper right corner of Card composable](https://stackoverflow.com/a/73182325/54578533)<br>
[Icon drawable inside IconButton is black despite it being white](https://stackoverflow.com/a/73180131/5457853)<br>
[What is clickable indication in jetpack compose?](https://stackoverflow.com/a/73175067/5457853)<br>

#### LaunchedEffect, SideEffect, DerivedStateOf, snapshotFlow

[Using SnapshotFlow to observe MutableState changes](https://stackoverflow.com/a/69235908/5457853)<br>
[Callback function can be changed in Compose? rememberUpdatedState](https://stackoverflow.com/a/72873305/5457853)<br>
[How can I launch a function only onetime when I use Jetpack Compose?](https://stackoverflow.com/questions/72946503/how-can-i-launch-a-function-only-onetime-when-i-use-jetpack-compose/72946980#72946980)<br>
[Does lazyColumn listen for events when items enter or leave the screen](https://stackoverflow.com/a/73077507/5457853)<br>
[Why do I need use derivedStateOf in Compose?](https://stackoverflow.com/a/73132540/5457853)<br>
[Click a close button on a bottomsheet to hide it in compose](https://stackoverflow.com/a/73552425/5457853)<br>
[How to show a composable just for e few seconds?](https://stackoverflow.com/a/73333356/5457853)<br>
[What would be the most 'lightweight' way to observe current time for a an android composable?](https://stackoverflow.com/a/73333458/5457853)<br>
[Difference between remember and rememberUpdatedState in Jetpack Compose?](https://stackoverflow.com/a/70223293/5457853)<br>
[Use of LaunchedEffect vs SideEffect in jetpack compose](https://stackoverflow.com/a/73802448/5457853)<br>
[Jetpack Compose recomposition race condition](https://stackoverflow.com/a/74242627/5457853)<br>
[how can I do resend email timer LaunchedEffect](https://stackoverflow.com/a/74633185/5457853)<br>
[LaunchedEffect vs rememberCoroutineScope. This explanation makes me confused. Please make it clear to me](https://stackoverflow.com/a/72824656/5457853)<br>
[MutableState callback in non-Composable](https://stackoverflow.com/a/73347171/5457853)<br>

#### Modifiers

[Jetpack Compose - Order of Modifiers](https://stackoverflow.com/a/74145347/5457853)<br>
[Create Custom Modifier](https://stackoverflow.com/a/70439902/5457853)<br>
[Composed Modifier](https://stackoverflow.com/a/70169164/5457853)<br>
[Why are the modifier sizes not overwritten?](https://stackoverflow.com/a/71678948/5457853)<br>
[How to achieve layout with where icon is position absolute on column layout Modifier.offset](https://stackoverflow.com/a/73091505/5457853)<br>
[Define Custom Boundaries for a Composable GraphicsLayer](https://stackoverflow.com/a/73470355/5457853)<br>
[Modifier- Is there a way to create and apply a style to multiple elements in Compose like we do with CSS](https://stackoverflow.com/a/73654523/5457853)<br>
[JetPack Compose - weight() in Row in Card doesn't work](https://stackoverflow.com/a/73643865/5457853)<br>
[How to calculate empty space in lazy column after last visible item](https://stackoverflow.com/a/74011277/5457853)<br>
[How To Get The Absolute Position Of My Composable Function/Children?](https://stackoverflow.com/a/74434621/5457853)<br>
[Use of LaunchedEffect vs SideEffect in jetpack compose](https://stackoverflow.com/a/73802448/5457853)<br>

#### Layout, Constraints

[Creating a SearchView](https://stackoverflow.com/a/69605371/5457853)<br>
[Create custom badges with size and colorful shadows](https://stackoverflow.com/a/70143863/5457853)<br>
[How to align one item to bottom using weight or Layout](https://stackoverflow.com/a/70905004/5457853)<br>
[How to create chat bubbles](https://stackoverflow.com/a/70938029/5457853)<br>
[Custom Tabs](https://stackoverflow.com/a/71377299/5457853)<br>
[Take screenshot of a Composable](https://stackoverflow.com/a/71902319/5457853)<br>
[Make last Item of the Compose LazyColumn fill rest of the screen](https://stackoverflow.com/questions/72936954/make-last-item-of-the-compose-lazycolumn-fill-rest-of-the-screen/72937753#72937753)<br>
[Row IntrinsicSize.Min not working when the children are async loading images SubcomposeLayout](https://stackoverflow.com/a/73105010/5457853)<br>
[Observing position of item in Lazy Column in Jetpack Compose](https://stackoverflow.com/a/73148733/5457853)<br>
[Jetpack Compose width / height / size modifier vs requiredWidth / requiredHeight / requiredSize](https://stackoverflow.com/a/73316247/5457853)<br>
[Jetpack Compose - layouting reusable components](https://stackoverflow.com/a/74286507/5457853)<br>
[Can't represent a size of 357913941 in Constraints in Jetpack Compose](https://stackoverflow.com/a/74575756/5457853)<br>
[Android compose, Indicator size problem with coil](https://stackoverflow.com/a/74491759/5457853)<br>

#### SubcomposeLayout

[How does SubcomposeLayout work?](https://stackoverflow.com/a/70383694/5457853)<br>
[How to create a Slider with SubcomposeLayout](https://stackoverflow.com/a/71792822/5457853)<br>
[Setting width of 2 buttons with SubcomposeLayout](https://stackoverflow.com/a/72940620/5457853)<br>
[How to adjust size of component to it's child and remain unchanged when it's child size will change?](https://stackoverflow.com/a/73706182/5457853)<br>
[Get information about size before is drawn in Compose](https://stackoverflow.com/a/73802696/5457853)<br>

#### Animation

[Animating with single recomposition with Canvas](https://stackoverflow.com/a/73274631/5457853)<br>
[Android Compose create shake animation](https://stackoverflow.com/a/73631379/5457853)<br>
[Issue with jetpack compose animation performance](https://stackoverflow.com/a/74588077/5457853)<br>
[animation o a lazycolumn android](https://stackoverflow.com/a/73325826/5457853)<br>
[Rotate Animation Compose](https://stackoverflow.com/a/73291875/5457853)<br>
[How to animate Rect position with Animatable?](https://stackoverflow.com/q/73555446/5457853)<br>

#### Gestures

[How gestures work in Jetpack Compose and onTouchEvent](https://stackoverflow.com/a/70847531/5457853)<br>
[Detect which section of image is touched](https://stackoverflow.com/a/71491531/5457853)<br>
[Detect when the user lifts their finger (off the screen)](https://stackoverflow.com/a/72210341/5457853)<br>
[How to detect the end of transform gesture in Jetpack Compose?](https://stackoverflow.com/a/72897829/5457853)<br>
[Combine detectTapGestures and detectDragGesturesAfterLongPress?](https://stackoverflow.com/a/72897829/5457853)<br>
[What is clickable indication in jetpack compose?](https://stackoverflow.com/a/73175067/5457853)<br>
[Prevent dragging box out of the screen with Jetpack Compose](https://stackoverflow.com/a/73307256/5457853)<br>
[JetPack Compose: Adding click duration](https://stackoverflow.com/a/73419818/5457853)<br>
[compose gestures, zoom in zoom out move and rotation](https://stackoverflow.com/a/73542156/5457853)<br>
[How to set Double back press Exit in Jetpack Compose?](https://stackoverflow.com/a/73754359/5457853)<br>
[Jetpack Compose detect drag gesture and detect Interaction source](https://stackoverflow.com/a/73488761/5457853)<br>
[How can one composible's clicks pass through to a composible underneath?](https://stackoverflow.com/a/73444016/5457853)<br>

#### Canvas, DrawScope

[How to apply Porter-Duff mode to image?](https://stackoverflow.com/a/69790654/5457853)<br>
[How to create drawing app with Jetpack Compose?](https://stackoverflow.com/a/71090112/5457853)<br>
[How to create HSL saturation and lightness change gradient or brush editor with Jetpack Compose?](https://stackoverflow.com/a/71496228/5457853)<br>
[How to create Angular gradient in Jetpack compose?](https://stackoverflow.com/a/71705164/5457853)<br>
[Angled gradient background in Jetpack Compose](https://stackoverflow.com/a/71716708/5457853)<br>
[how to draw a square with stroke and neon glow with Jetpack Compose Canvas?](https://stackoverflow.com/a/72975726/5457853)<br>
[Jetpack compose Drawing over shapes in a path](https://stackoverflow.com/a/72969383/5457853)<br>
[Cubic with Canvas](https://stackoverflow.com/a/73469065/5457853)<br>
[What is the unit of Canvas's size when I use Compose?](https://stackoverflow.com/a/73233376/5457853)<br>
[How to draw a multicolored bar with Canvas in Jetpack Compose?](https://stackoverflow.com/a/73547525/5457853)<br>
[How to clip or cut a Composable with BlendModes?](https://stackoverflow.com/a/73590696/5457853)<br>
[How to center Text in Canvas in Jetpack compose?](https://stackoverflow.com/a/73352227/5457853)<br>
[How to divide the stroke of a circle at equal intervals in Jetpack compose canvas?](https://stackoverflow.com/a/73677601/5457853)<br>
[Jetpack compose custom shape with pie effect](https://stackoverflow.com/a/73950607/5457853)<br>
[How to apply PathEffect without using Stroke with Jetpack Compose?](https://stackoverflow.com/a/74327086/5457853)<br>
[Jetpack Compose - CardView with Arc Shape on border](https://stackoverflow.com/a/74285035/5457853)<br>
[Jetpack Compose: how to cut out card shape?](https://stackoverflow.com/a/74076087/5457853)<br>
[Jetpack Compose: How to create a rating bar?](https://stackoverflow.com/a/73996333/5457853)<br>
[Watermark or write on Bitmap with androidx.compose.ui.graphics.Canvas?](https://stackoverflow.com/a/74603521/5457853)<br>
[Image Cropper](https://stackoverflow.com/a/73819758/5457853)<br>
[Vertical scroll on Canvas (Jetpack Compose)](https://stackoverflow.com/a/73225175/5457853)<br>
[Why can I draw a line out of the canvas when I use Jetpack Compose?](https://stackoverflow.com/a/73303026/5457853)<br>
[implement a spinning activity indicator with Jetpack Compose](https://stackoverflow.com/a/74199392/5457853)<br>

### Resources and References

[Codelab Jetpack Compose Basics](https://developer.android.com/codelabs/jetpack-compose-basics)
<br>
[Codelab Jetpack Compose Layouts](https://developer.android.com/codelabs/jetpack-compose-layouts?hl=en#0)
<br>
[Codelab Jetpack Compose States](https://developer.android.com/codelabs/jetpack-compose-state?hl=en#0)
<br>
[Codelab Jetpack Compose Advanced State](https://developer.android.com/codelabs/jetpack-compose-advanced-state-side-effects?hl=en#0)
<br>
[Developer Android](https://developer.android.com/jetpack/compose/mental-model)
<br>
[Developer Android Material](https://developer.android.com/reference/kotlin/androidx/compose/material/package-summary#theming)
<br>
[Jetpack Compose Samples](https://github.com/android/compose-samples)
<br>
[Under the hood of Jetpack Compose — part 2 of 2- Leland Richardson](https://medium.com/androiddevelopers/under-the-hood-of-jetpack-compose-part-2-of-2-37b2c20c6cdd)
<br>
[What is “donut-hole skipping” in Jetpack Compose?-Vinay Gaba](https://www.jetpackcompose.app/articles/donut-hole-skipping-in-jetpack-compose)
<br>
[Android Graphics](https://developer.android.com/jetpack/compose/graphics)
<br>
[Playing with Paths-Nick Butcher](https://medium.com/androiddevelopers/playing-with-paths-3fbc679a6f77)
<br>
[Custom Shape with Jetpack Compose-Julien Salvi](https://juliensalvi.medium.com/custom-shape-with-jetpack-compose-1cb48a991d42)
<br>
[Porter Duff Mode](https://developer.android.com/reference/android/graphics/PorterDuff.Mode)
<br>
[Porter/Duff Compositing and Blend Modes](http://ssp.impulsetrain.com/porterduff.html)
<br>
[Practical Image PorterDuff Mode Usage in Android-Elye](https://medium.com/mobile-app-development-publication/practical-image-porterduff-mode-usage-in-android-3b4b5d2e8f5f)
<br>
[Android Image Lighting Control and Color Filtering-Elye](https://medium.com/mobile-app-development-publication/android-image-lighting-control-and-color-filtering-89f51a139a79)
<br>
[Android Image Color Change With ColorMatrix-Elye](https://medium.com/mobile-app-development-publication/android-image-color-change-with-colormatrix-e927d7fb6eb4)
<br>
[Manipulating images and Drawables with Android’s ColorFilter-Nick Rout](https://medium.com/over-engineering/manipulating-images-and-drawables-with-androids-colorfilter-25bf061843e7)
<br>
[Curved (Cut out) Bottom Navigation With Animation in Android](https://medium.com/swlh/curved-cut-out-bottom-navigation-with-animation-in-android-c630c867958c)
<br>
[Gooey Effect Using Canvas API In Android](https://laewoong.github.io/android-gooey-effect/)
<br>
[movableContentOf and movableContentWithReceiverOf-Jorge Castillo](https://newsletter.jorgecastillo.dev/p/movablecontentof-and-movablecontentwithreceivero)
<br>
[Jetpack Compose Stability Explained-Ben Trengrove](https://medium.com/androiddevelopers/jetpack-compose-stability-explained-79c10db270c8)
<br>
[Composable metrics-Chris Banes](https://chrisbanes.me/posts/composable-metrics/)
<br>
