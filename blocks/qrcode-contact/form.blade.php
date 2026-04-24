<?php
use App\Models\Button;

$buttonOptions = Button::where('exclude', false)->orderBy('alt', 'asc')->get();
$selectedButtonId = $button_id ?: $buttonOptions->first()?->id;
$qrDescription = $qr_description ?? '';
$qrImagePath = $qr_image_path ?? '';
?>

<label for="title" class="form-label">按钮标题</label>
<input type="text" name="title" value="{{ $title }}" class="form-control" required />
<span class="small text-muted">例如：添加微信、扫码联系、加入社群</span>
<br>

<label for="button_id" class="form-label">按钮样式</label>
<select name="button_id" class="form-control" required>
    @foreach ($buttonOptions as $option)
        <option value="{{ $option->id }}" {{ (int) $selectedButtonId === (int) $option->id ? 'selected' : '' }}>
            {{ $option->alt }}
        </option>
    @endforeach
</select>
<span class="small text-muted">选择前台按钮的图标和颜色风格</span>
<br><br>

<label for="qr_description" class="form-label">弹窗说明</label>
<textarea name="qr_description" class="form-control" rows="3" placeholder="请使用微信扫码添加">{{ $qrDescription }}</textarea>
<span class="small text-muted">会显示在二维码下方，可留空</span>
<br>

<label for="qr_image" class="form-label">二维码图片</label>
<input type="file" name="qr_image" class="form-control" accept=".png,.jpg,.jpeg,.webp" {{ $qrImagePath ? '' : 'required' }} />
<span class="small text-muted">支持 PNG / JPG / WEBP，建议使用清晰的正方形二维码</span>

@if ($qrImagePath)
    <input type="hidden" name="current_qr_image" value="{{ $qrImagePath }}" />
    <br><br>
    <div>
        <div class="small text-muted mb-2">当前二维码预览</div>
        <img src="{{ url($qrImagePath) }}" alt="当前二维码" style="max-width: 220px; width: 100%; border-radius: 12px; border: 1px solid #d9dee8; padding: 8px; background: #fff;">
    </div>
@endif
