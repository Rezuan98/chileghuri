<div class="ldrs-loader" id="ldrsLoader" style="display: none;">
    <div class="loader-overlay"></div>
    <div class="loader-content">
        <l-orbit size="35" speed="1.5" color="#4F0808"></l-orbit>
        <p>Loading...</p>
    </div>
</div>

<style>
.ldrs-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
}

.loader-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
}

.loader-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.loader-content p {
    margin-top: 15px;
    color: #4F0808;
    font-weight: 500;
}
</style>