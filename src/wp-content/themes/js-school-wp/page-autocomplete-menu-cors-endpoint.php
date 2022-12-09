<?php
/**
 * The template for displaying Autocomplete menu & CORS endpoint page
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JS_School_WP
 */

get_header();

?>

<div class="container-fluid bg-secondary bg-opacity-10">
    <div class="container p-5">
        <h1 class="display-5 text-uppercase fw-bold">Make the digital connection</h1>
        <p class="lead text-muted">
            Interested in learning more about REEF education?
            <br/>
            We'd love to hear from you.
        </p>

        <div class="row">
            <div class="col-lg-8">
                <form>
                    <input class="form-control form-control-lg mb-3" type="text" name="firstName" id="firstName" placeholder="First Name">

                    <input class="form-control form-control-lg mb-3" type="text" name="lastName" id="lastName" placeholder="Last Name">

                    <input class="form-control form-control-lg mb-3" type="email" name="email" id="email" placeholder="Email Address">

                    <input class="form-control form-control-lg mb-3" type="tel" name="phone" id="phone" placeholder="Phone Number">

                    <div class="autocomplete mb-3">
                        <input class="form-control form-control-lg" type="text" name="organization" id="list" placeholder="Organization" autocomplete="off">
                        <div id="autocomplete-menu">
                            <div class="list-group">
                                <li class="list-group-item d-none" id="loadingAnimation">
                                    <span class="spinner-grow spinner-grow-sm text-secondary" role="status" aria-hidden="true"></span>
                                    <span class="visually-hidden">Loading...</span>
                                </li>
                            </div>
                        </div>
                    </div>

                    <select class="form-select form-select-lg mb-3" name="organizationType" id="organizationType">
                        <option selected>Organization Type</option>
                        <option value="1">...</option>
                    </select>

                    <select class="form-select form-select-lg mb-3" name="role" id="role">
                        <option selected>Role</option>
                        <option value="1">...</option>
                    </select>

                    <select class="form-select form-select-lg mb-3" name="country" id="country">
                        <option selected>Country</option>
                        <option value="1">...</option>
                    </select>

                    <input class="form-control form-control-lg mb-3" type="text" name="city" id="city" placeholder="City">

                    <div class="mb-3">
                        <select class="form-select form-select-lg mb-3" name="productInterest" id="productInterest" aria-describedby="productInterestHelp">
                            <option selected>Product Interest</option>
                            <option value="1">...</option>
                        </select>
                        <div id="productInterestHelp" class="form-text">
                            <p class="fst-italic mb-0">Not sure which product is right for you?</p>
                            <a href="#" class="text-decoration-none">Click here for a product comparison.</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-lg btn-secondary my-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

get_footer();
