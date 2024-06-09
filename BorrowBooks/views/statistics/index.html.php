<?php
/**
 * @var File[] $books
 */

use Bookstore\Models\File;

?>

{% extends views/layout.html.php %}

{% block styles %}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
{% endblock %}

{% block toolbar %}
    <header>Statistics</header>
{% endblock %}

{% block content %}
    <div class="grid">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 books on trending</h5>
                        <canvas id="bookChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Most famous authors</h5>
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
{% endblock %}

{% block javascript %}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="assets/js/statistics.js"></script>
{% endblock %}
