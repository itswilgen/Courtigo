<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('player')->after('password');
            $table->string('phone')->nullable()->after('role');
            $table->string('status')->default('active')->after('phone');
        });

        Schema::create('vendor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('business_name');
            $table->string('business_email')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('business_address');
            $table->string('city');
            $table->string('requirements_file')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('duration_days');
            $table->unsignedInteger('court_limit')->nullable();
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('vendor_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_plan_id')->constrained();
            $table->string('status')->default('active');
            $table->date('starts_at');
            $table->date('expires_at');
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_provider')->default('gcash');
            $table->timestamps();
        });

        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_profile_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('location');
            $table->string('city');
            $table->text('description');
            $table->decimal('hourly_rate', 10, 2);
            $table->string('surface_type')->default('acrylic');
            $table->unsignedTinyInteger('capacity')->default(4);
            $table->string('status')->default('active');
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating_average', 3, 2)->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->timestamps();
        });

        Schema::create('court_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('court_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->time('opens_at');
            $table->time('closes_at');
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });

        Schema::create('court_time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->date('slot_date');
            $table->time('starts_at');
            $table->time('ends_at');
            $table->string('status')->default('available');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->unique(['court_id', 'slot_date', 'starts_at']);
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->foreignId('court_time_slot_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference')->unique();
            $table->date('booking_date');
            $table->time('starts_at');
            $table->time('ends_at');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->unique(['court_id', 'booking_date', 'starts_at']);
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vendor_subscription_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');
            $table->string('provider');
            $table->string('transaction_reference')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('paid');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('audience')->default('user');
            $table->string('title');
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reported_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('court_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category');
            $table->text('description');
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('court_time_slots');
        Schema::dropIfExists('court_schedules');
        Schema::dropIfExists('court_images');
        Schema::dropIfExists('courts');
        Schema::dropIfExists('vendor_subscriptions');
        Schema::dropIfExists('subscription_plans');
        Schema::dropIfExists('vendor_profiles');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'status']);
        });
    }
};
