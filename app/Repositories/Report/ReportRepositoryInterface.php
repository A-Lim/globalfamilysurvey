<?php
namespace App\Repositories;

use App\Report;
use Illuminate\Http\Request;

interface ReportRepositoryInterface
{
    /**
     * Retrieve all reports
     *
     * @return [Report]
     */
    public function all();

    /**
     * Retrieve network by id
     *
     * @param integer $id
     * @return Report
     */
    public function find($id);

    /**
     * Create report
     *
     * @param Request $request
     * @return Report
     */
    public function create(Request $request);

    /**
     * Update report
     *
     * @param Report $report
     * @param Request $request
     * @return null
     */
    public function update(Report $report, Request $request);

    /**
     * Delete report
     *
     * @param Report $report
     * @return null
     */
    public function delete(Report $report);

    /**
     * Retrieve data for chart.js
     *
     * @param Report $report
     * @param string $filter 
     * @return array
     */
    public function data(Report $report, $filter = null);

    /**
     * Retrieve all report data for chart.js
     *
     * @param string $filter 
     * @return array
     */
    public function grouped_report_details($filter = null);
}
