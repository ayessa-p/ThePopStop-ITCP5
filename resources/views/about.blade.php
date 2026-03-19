@extends('layouts.app')

@section('title', 'About Us - The Pop Stop')

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, var(--accent), var(--primary));
        color: white;
        padding: 4rem 2rem;
        border-radius: 20px;
        text-align: center;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(139, 0, 0, 0.2);
    }
    .about-hero h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
        font-weight: 800;
    }
    .about-hero p {
        font-size: 1.25rem;
        opacity: 0.9;
    }
    .about-section {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        margin-bottom: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    .about-section h2 {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }
    .location-details h3 {
        font-size: 1.25rem;
        color: var(--dark-brown);
        margin-bottom: 0.5rem;
    }
    .location-details p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    .contact-item {
        background: var(--bg);
        padding: 1.5rem;
        border-radius: 12px;
    }
    .contact-item h4 {
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    .offer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    .offer-card {
        background: var(--bg);
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        transition: transform 0.3s ease;
    }
    .offer-card:hover {
        transform: translateY(-5px);
    }
    .offer-card h3 {
        color: var(--primary);
        margin-bottom: 1rem;
        font-size: 1.3rem;
    }
    .offer-card p {
        font-size: 0.95rem;
        color: #555;
        line-height: 1.5;
    }
    .why-choose-list {
        list-style: none;
        padding: 0;
    }
    .why-choose-list li {
        padding: 1.25rem 0;
        border-bottom: 1px solid #eee;
        color: #444;
        display: flex;
        align-items: center;
    }
    .why-choose-list li:last-child {
        border-bottom: none;
    }
    .why-choose-list li::before {
        content: "✓";
        color: var(--primary);
        font-weight: bold;
        margin-right: 1rem;
        font-size: 1.2rem;
    }
    .about-cta {
        background: var(--dark-brown);
        color: white;
        padding: 4rem 2rem;
        border-radius: 20px;
        text-align: center;
        margin-top: 4rem;
    }
    .about-cta h2 {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
    }
    .about-cta p {
        margin-bottom: 2rem;
        font-size: 1.1rem;
        opacity: 0.8;
    }
</style>
@endpush

@section('content')
<div class="about-container">
    <!-- Hero Section -->
    <div class="about-hero">
        <h1>About The Pop Stop</h1>
        <p>Your trusted destination for collectible figurines</p>
    </div>

    <!-- Our Location -->
    <div class="about-section">
        <h2>Our Location</h2>
        <div class="location-details">
            <h3>Western Bicutan, Taguig City</h3>
            <p>Philippines</p>
            <p>Visit our store to explore our extensive collection of Pop Mart and Funko figures. We're conveniently located in the heart of Taguig City, making it easy for collectors to find their favorite pieces.</p>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="about-section">
        <h2>Contact Information</h2>
        <div class="contact-grid">
            <div class="contact-item">
                <h4>Email</h4>
                <p>thepopstopmail@gmail.com</p>
            </div>
            <div class="contact-item">
                <h4>Phone</h4>
                <p>0912-573-5465</p>
            </div>
        </div>
    </div>

    <!-- What We Offer -->
    <div class="about-section">
        <h2>What We Offer</h2>
        <div class="offer-grid">
            <div class="offer-card">
                <h3>Pop Mart Figures</h3>
                <p>Exclusive collection of Hirono, Skullpanda, Crybaby, Labubu, and Pino Jelly figurines</p>
            </div>
            <div class="offer-card">
                <h3>Funko Pop! Vinyl</h3>
                <p>Wide selection of Marvel, DC Comics, Anime, and Gaming character figures</p>
            </div>
            <div class="offer-card">
                <h3>Limited Editions</h3>
                <p>Rare and exclusive collectibles for serious collectors</p>
            </div>
            <div class="offer-card">
                <h3>Blind Boxes</h3>
                <p>Experience the thrill of surprise with our blind box collections</p>
            </div>
        </div>
    </div>

    <!-- Why Choose Us? -->
    <div class="about-section">
        <h2>Why Choose Us?</h2>
        <ul class="why-choose-list">
            <li>Authentic and genuine products from official suppliers</li>
            <li>Competitive pricing on all items</li>
            <li>Regular stock updates with the latest releases</li>
            <li>Secure packaging and careful handling</li>
            <li>Excellent customer service</li>
            <li>Easy online ordering and convenient payment options</li>
        </ul>
    </div>

    <!-- CTA Section -->
    <div class="about-cta">
        <h2>Ready to Start Collecting?</h2>
        <p>Browse our catalog and find your next favorite figure!</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg" style="padding: 1rem 2.5rem; font-size: 1.2rem; border-radius: 50px;">Shop Now</a>
    </div>
</div>
@endsection
