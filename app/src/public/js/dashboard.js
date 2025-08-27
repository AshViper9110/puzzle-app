// public/js/dashboard.js
/**
 * ダッシュボード JavaScript
 * @version 1.0.0
 */

class DashboardManager {
    constructor() {
        this.particleCount = 15;
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.createParticles();
            this.initNavItemEffects();
            this.initPerformanceOptimization();
        });
    }

    // 浮遊パーティクルエフェクト
    createParticles() {
        const particlesContainer = document.querySelector('.floating-particles');
        if (!particlesContainer) return;

        for (let i = 0; i < this.particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 8 + 's';
            particle.style.animationDuration = (Math.random() * 3 + 6) + 's';
            particlesContainer.appendChild(particle);
        }
    }

    // ナビゲーションアイテムのエフェクト
    initNavItemEffects() {
        const navItems = document.querySelectorAll('.nav-item');

        navItems.forEach(item => {
            item.addEventListener('mouseenter', this.handleNavItemHover.bind(this));
            item.addEventListener('mouseleave', this.handleNavItemLeave.bind(this));
            item.addEventListener('click', this.handleNavItemClick.bind(this));
        });
    }

    handleNavItemHover(event) {
        event.currentTarget.style.transform = 'translateY(-8px) scale(1.02)';
    }

    handleNavItemLeave(event) {
        event.currentTarget.style.transform = 'translateY(0) scale(1)';
    }

    handleNavItemClick(event) {
        const item = event.currentTarget;
        item.style.transform = 'translateY(-4px) scale(0.98)';

        setTimeout(() => {
            item.style.transform = 'translateY(-8px) scale(1.02)';
        }, 150);
    }

    // パフォーマンス最適化
    initPerformanceOptimization() {
        // Intersection Observer でアニメーション制御
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const animationState = entry.isIntersecting ? 'running' : 'paused';
                entry.target.style.animationPlayState = animationState;
            });
        }, {threshold: 0.1});

        // パーティクルの監視
        document.querySelectorAll('.particle').forEach(particle => {
            observer.observe(particle);
        });

        // Reduced motion の考慮
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.querySelectorAll('.particle').forEach(particle => {
                particle.style.animation = 'none';
            });
        }
    }

    // ダークモード切り替え (将来の拡張用)
    toggleDarkMode() {
        document.body.classList.toggle('light-theme');
        localStorage.setItem('theme', document.body.classList.contains('light-theme') ? 'light' : 'dark');
    }

    // エラーハンドリング
    handleError(error) {
        console.error('Dashboard Error:', error);
        // エラー通知UIを表示
        this.showNotification('エラーが発生しました', 'error');
    }

    // 通知システム
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification--${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// インスタンス化
const dashboard = new DashboardManager();

// グローバル関数として公開（必要に応じて）
window.Dashboard = dashboard;
