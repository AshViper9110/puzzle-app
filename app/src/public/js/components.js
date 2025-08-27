// public/js/components.js
/**
 * 再利用可能コンポーネント JavaScript
 */

class ComponentManager {
    static initTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');

        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', this.showTooltip);
            element.addEventListener('mouseleave', this.hideTooltip);
        });
    }

    static showTooltip(event) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = event.target.dataset.tooltip;
        document.body.appendChild(tooltip);

        const rect = event.target.getBoundingClientRect();
        tooltip.style.left = rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
    }

    static hideTooltip() {
        const tooltip = document.querySelector('.tooltip');
        if (tooltip) tooltip.remove();
    }

    static initModal() {
        // モーダル機能（将来の拡張用）
    }
}

// 自動初期化
document.addEventListener('DOMContentLoaded', () => {
    ComponentManager.initTooltips();
});
