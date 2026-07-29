/**
 * Common Rows Per Page Selector helper for portal tables
 */
function initRowsPerPage(config) {
    if (!config || !config.onChange) {
        console.error('initRowsPerPage requires an onChange callback.');
        return;
    }

    const targetSelector = config.targetSelector;
    const selectorId = config.selectorId || 'rows-per-page-select';
    
    // Check if selector already exists
    if ($('#' + selectorId).length) {
        return;
    }

    const $target = $(targetSelector);
    if (!$target.length) {
        // Retry later if element is not loaded yet
        setTimeout(() => initRowsPerPage(config), 100);
        return;
    }

    const defaultSize = config.defaultSize || 10;
    const allowedSizes = [10, 15, 20, 50, 100];
    
    let optionsHtml = '';
    // If the default size is not one of the standard ones, prepend it
    if (defaultSize && !allowedSizes.includes(defaultSize)) {
        optionsHtml += `<option value="${defaultSize}">${defaultSize}</option>`;
    }
    
    allowedSizes.forEach(size => {
        optionsHtml += `<option value="${size}">${size}</option>`;
    });

    const itemClass = config.itemClass || '';
    const labelClass = config.labelClass || '';
    const selectClass = config.selectClass || 'form-input-style';

    let labelHtml = '';
    if (config.labelName) {
        labelHtml = `<span class="${labelClass}" style="font-size: 12.5px; font-weight: 600; color: #475569; white-space: nowrap;">${config.labelName}</span>`;
    }

    // Align right in flexbox container using margin-left: auto
    const containerStyle = `display: flex; flex-direction: column; gap: 6px; margin-left: auto; align-items: flex-start;`;

    const dropdownHtml = `
        <div class="${itemClass} rows-per-page-container" style="${containerStyle}">
            ${labelHtml}
            <select id="${selectorId}" class="${selectClass}" style="width: 80px; height: 36px; padding: 0 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; cursor: pointer; color: #0f172a; outline: none; background: #fff; display: inline-block;">
                ${optionsHtml}
            </select>
        </div>
    `;

    // Append it inside the filters row container
    $target.append(dropdownHtml);

    const $select = $('#' + selectorId);
    $select.val(defaultSize);

    $select.on('change', function() {
        const newSize = parseInt($(this).val());
        config.onChange(newSize);
    });
}
