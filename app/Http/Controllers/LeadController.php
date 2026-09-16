<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $leads = Lead::query()
            ->search($request->query('search'))
            ->status($request->query('status'))
            ->source($request->query('source'))
            ->with('assignedTo')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $users = User::orderBy('name')->get();

        return view('leads.index', [
            'leads' => $leads,
            'users' => $users,
            'statuses' => Lead::STATUSES,
            'sources' => Lead::SOURCES,
            'filters' => $request->only('search', 'status', 'source'),
        ]);
    }

    public function create()
    {
        return view('leads.create', [
            'users' => User::orderBy('name')->get(),
            'statuses' => Lead::STATUSES,
            'sources' => Lead::SOURCES,
        ]);
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        Lead::create($request->validated() + ['created_by' => $request->user()->id]);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        $lead->load('assignedTo', 'creator');

        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        return view('leads.edit', [
            'lead' => $lead,
            'users' => User::orderBy('name')->get(),
            'statuses' => Lead::STATUSES,
            'sources' => Lead::SOURCES,
        ]);
    }

    public function update(UpdateLeadRequest $request, Lead $lead): RedirectResponse
    {
        $lead->update($request->validated());

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        Gate::authorize('delete', $lead);

        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    
    public function updateStatus(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Lead::STATUSES)],
        ]);

        $lead->update($validated);

        return back()->with('success', 'Lead status updated successfully.');
    }

    
    public function export(Request $request): StreamedResponse
    {
        $leads = Lead::query()
            ->search($request->query('search'))
            ->status($request->query('status'))
            ->source($request->query('source'))
            ->with('assignedTo')
            ->latest()
            ->get();

        $filename = 'leads_export_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($leads) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Company', 'Status', 'Source', 'Assigned To', 'Created At']);

            foreach ($leads as $lead) {
                fputcsv($handle, [
                    $lead->id,
                    $lead->name,
                    $lead->email,
                    $lead->phone,
                    $lead->company_name,
                    $lead->status,
                    $lead->source,
                    $lead->assignedTo?->name ?? '-',
                    $lead->created_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
