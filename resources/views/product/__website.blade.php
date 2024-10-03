@extends('layouts.admin')

@section('title', 'Product')

@section('styles')

@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Product / </span>Web</h4>
    <form id="productWebForm" name="productWebForm" class="form-horizontal">
        <input type="hidden" name="product_id" value="{{$product_id}}">
                <div class="row">
                  <div class="col-12 col-lg-12">
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="Color Enhancing">Color Enhancing</label>
                            <select class="form-select" name="color_enhancing" id="color_enhancing" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Countertops/Vanities">Countertops/Vanities
                            </label>
                            <select class="form-select" name="countertop_vanities" id="countertop_vanities" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Interior Floor">Interior Floor
                            </label>
                            <select class="form-select" name="interior_floor" id="interior_floor" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>

                          </div>
                          <div class="col">
                            <label class="form-label" for="Fireplace/Interior Wal">Fireplace/Interior Wall
                            </label>
                            <select class="form-select" name="fireplace_interior_wall" id="fireplace_interior_wall" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>

                        </div>
                        <div class="row mb-3">

                          <div class="col">
                            <label class="form-label" for="Shower Wall">Shower Wall
                            </label>
                            <select class="form-select" name="shower_wall" id="shower_wall" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Shower Floor">Shower Floor</label>
                            <select class="form-select" name="shower_floor" id="shower_floor" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Exterior Floor">Exterior Floor
                            </label>
                            <select class="form-select" name="exterior_floor" id="exterior_floor" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Exterior Wall">Exterior Wall</label>
                            <select class="form-select" name="exterior_wall" id="exterior_wall" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        </div>
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="Pool/Fountain">Pool/Fountain</label>
                            <select class="form-select" name="pool_fountain" id="pool_fountain" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label" for="Furniture Top">Furniture Top
                            </label>
                            <select class="form-select" name="furniture_top" id="furniture_top" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Translucent">Translucent
                            </label>
                            <select class="form-select" name="translucent" id="translucent" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Cut To Size">Cut To Size</label>
                            <select class="form-select" name="cut_to_size" id="cut_to_size" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="row mb-3">
                          <div class="col">Sealer</label>
                          <select class="form-select" name="sealer" id="sealer" data-allow-clear="true">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Abrasion Resistance">Abrasion Resistance
                            </label>
                            <select class="form-select" name="abrasion_resistance" id="abrasion_resistance" data-allow-clear="true">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>

                          <div class="col">
                            <label class="form-label" for="Stain Resistance">Stain Resistance
                            </label>
                            <select class="form-select" name="stain_resistance" id="stain_resistance" data-allow-clear="true">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Etching Resistance">Etching Resistance</label>
                            <select class="form-select" name="etching_resistance" id="etching_resistance" data-allow-clear="true">
                              <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>

                        </div>
                        <div class="row mb-3">

                          <div class="col">
                            <label class="form-label" for="Heat Resistance">Heat Resistance</label>
                            <select class="form-select" name="heat_resistance" id="heat_resistance" data-allow-clear="true">
                              <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="UV Resistance">UV Resistance</label>
                            <select class="form-select" name="uv_resistance" id="uv_resistance" data-allow-clear="true">
                            <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Color Range">Color Range
                            </label>
                            <select class="form-select" name="color_range" id="color_range" data-allow-clear="true">
                            <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Movement Index">Movement Index</label>
                            <select class="form-select" name="movement_index" id="movement_index" data-allow-clear="true">
                            <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="N/A">N/A</option>
                            </select>
                          </div>
                          </div>
                      </div>
                    </div>
                </div>
                  <div class="form-group text-center">
              <button type="submit" class="btn btn-primary" id="savedataWeb" value="create">Save Web Data </button>
            </div>
        </div>
  </form>
  </div>
</div>
@endsection
@section('scripts')
@include('product.__scripts')
@endsection
