<?php
/* ORDER FORM */
function orderForm( array $data ) : void {
    echo <<<HTML
            <form action="/inventory" id="inventory-form" method="POST">
                <label> Filter
                    <select name="inventory-filter" id="inventory-filter">
                        <option value="brand">Brand</option>
                        <option value="type">Type</option>
                    </select>
                </label>
                <br>
                <label>
                    Input:
                    <input type="text" name="input-search" id="" placeholder="...">
                </label>
                <br>
                <!-- TODO: Make range dynamic. -->
                <input type="range"
                       min="0" max="300" step="20"
                       name="inventory-filter-range" id="inventory-filter-range">
                <label id="inventory-filter-label" for="inventory-filter-range"></label><span>€</span>
                <!--<input type="hidden" name="__method" value="POST">-->
                <!--<input type="hidden" name="id" value="">-->
                <br>
                <input type="submit" value="Search">
            </form>
            <br>
            <script>
                const label = document.querySelector('#inventory-filter-label');
                const range = document.querySelector('#inventory-filter-range');
                label.textContent = range.value;
        
                range.addEventListener( 'input', () => {
                    label.textContent = range.value;
                }, false );
            </script>
        HTML;

}