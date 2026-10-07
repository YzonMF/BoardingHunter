<div>
    <label for="Title" style="display:block; font-weight:bold; margin-top:12px;">Title</label>
    <input type="text" id="Title" name="Title" maxlength="150" required
           value="{{ old('Title', $post->Title ?? '') }}" style="width:100%; padding:8px; box-sizing:border-box;">
    @error('Title') <div style="color:#b00;">{{ $message }}</div> @enderror

    <label for="Content" style="display:block; font-weight:bold; margin-top:12px;">Content</label>
    <textarea id="Content" name="Content" rows="8" maxlength="5000" required
              style="width:100%; padding:8px; box-sizing:border-box;">{{ old('Content', $post->Content ?? '') }}</textarea>
    @error('Content') <div style="color:#b00;">{{ $message }}</div> @enderror
</div>
