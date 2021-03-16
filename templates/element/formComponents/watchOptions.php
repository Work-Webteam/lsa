<div class="form-group">
    <label for="watch_size"> Watch Size:</label>
    <select class="form-control" name="watch_size" id="watch_size" v-model="watchSize">
        <option disabled selected>Select Watch Size</option>
        <option>38mm face with 20mm strap</option>
        <option>29mm face with 14mm strap</option>
    </select>
</div>


<div class="form-group">
    <label for="watch_colour">Watch Colour:</label>
    <select class="form-control" name="watch_colour" id="watch_colour" v-model="watchColour">
        <option disabled selected>Select a colour</option>
        <option>Gold</option>
        <option>Silver</option>
        <option>Two-Toned (Gold &amp; Silver)</option>
    </select>
</div>

<div class="form-group">
    <label for="strap_type">Strap:</label>
    <select  class="form-control" name="strap_type" id="strap_type" v-model="strapType">
        <option disabled selected>Choose Strap</option>
        <option>Plated</option>
        <option>Black Leather</option>
        <option>Brown Leather</option>
    </select>
</div>

<div class="form-group">
    <label for="watch_engraving">Engraving</label>
    <input class="form-control" type="text" name="watch_engraving" maxlength="33" :placeholder="firstName + ' ' + lastName" id="watch_engraving" v-model="watchEngraving">
</div>
