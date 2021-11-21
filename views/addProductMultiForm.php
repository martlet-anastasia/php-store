<form action="/save_product" method="post" enctype="multipart/form-data">
    <input type="text" name="name">
    <input type="file" name="img[]" multiple="multiple">
    <textarea name="description"></textarea>

    <button type="submit">Send</button>
</form>
