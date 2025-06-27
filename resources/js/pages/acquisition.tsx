import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { router, usePage } from '@inertiajs/react';
import {
    ColumnDef,
    ColumnFiltersState,
    flexRender,
    getCoreRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    SortingState,
    useReactTable,
    VisibilityState,
} from '@tanstack/react-table';
import * as React from 'react';

export type IAcquisition = {
    nip: string;
    name: string;
    product: string;
    branch_id: string;
    month: string;
    year: string;
    customer: string;
};

export default function Acquisition() {
    const { data: propsData, columnDefinition: colDefs, filter: filterKey } = usePage().props;
    const filter = filterKey as string;
    const data = propsData as IAcquisition[];
    const showFilter = ['Raw Data', 'By Branch', 'By Employee'];

    const handleDropdownChange = (value: string) => {

        setShowData(value);

        router.get(
            '/',
            {
                show: value,
            },
            {
                preserveScroll: true,
                preserveState: true,
                replace: true,
            },
        );
    };

    const columns = React.useMemo(() => {
        const colItems = colDefs as ColumnDef<IAcquisition>[];
        const cols = Object.entries(colItems).map(([key, value]: any) => ({
            accessorKey: key,
            header: value,
            cell: ({ row }) => <div className="capitalize">{row.getValue(key)}</div>,
        }));
        return cols as ColumnDef<IAcquisition>[];
    }, [colDefs]);

    const [showData, setShowData] = React.useState<string>('Raw Data');
    const [sorting, setSorting] = React.useState<SortingState>([]);
    const [columnFilters, setColumnFilters] = React.useState<ColumnFiltersState>([]);
    const [columnVisibility, setColumnVisibility] = React.useState<VisibilityState>({});
    const [rowSelection, setRowSelection] = React.useState({});
    const table = useReactTable({
        data,
        columns,
        onSortingChange: setSorting,
        onColumnFiltersChange: setColumnFilters,
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        getSortedRowModel: getSortedRowModel(),
        getFilteredRowModel: getFilteredRowModel(),
        onColumnVisibilityChange: setColumnVisibility,
        onRowSelectionChange: setRowSelection,
        state: {
            sorting,
            columnFilters,
            columnVisibility,
            rowSelection,
        },
    });

    return (
        <div className="px-6 lg:px-10">
            <div className="w-full">
                <div className="flex justify-between py-4">
                    <Input
                        placeholder={`Filter ${filter}...`}
                        value={(table.getColumn(filter)?.getFilterValue() as string) ?? ''}
                        onChange={(event) => table.getColumn(filter)?.setFilterValue(event.target.value)}
                        className="max-w-sm"
                    />
                    <Select onValueChange={handleDropdownChange}>
                        <SelectTrigger className="float-right w-40">
                            {showData}
                        </SelectTrigger>
                        <SelectContent align="end">
                            {showFilter.map((item) => (
                                <SelectItem key={item} className="" value={item}>
                                    {item}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>
                <div className="rounded-md border">
                    <Table>
                        <TableHeader>
                            {table.getHeaderGroups().map((headerGroup) => (
                                <TableRow key={headerGroup.id}>
                                    {headerGroup.headers.map((header) => {
                                        return (
                                            <TableHead key={header.id}>
                                                {header.isPlaceholder ? null : flexRender(header.column.columnDef.header, header.getContext())}
                                            </TableHead>
                                        );
                                    })}
                                </TableRow>
                            ))}
                        </TableHeader>
                        <TableBody>
                            {table.getRowModel().rows?.length ? (
                                table.getRowModel().rows.map((row) => (
                                    <TableRow key={row.id} data-state={row.getIsSelected() && 'selected'}>
                                        {row.getVisibleCells().map((cell) => (
                                            <TableCell key={cell.id}>{flexRender(cell.column.columnDef.cell, cell.getContext())}</TableCell>
                                        ))}
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={columns.length} className="h-24 text-center">
                                        No results.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>
                <div className="flex items-center justify-end space-x-2 py-4">
                    <div className="flex-1 text-sm text-muted-foreground">
                        Page {table.getState().pagination.pageIndex + 1} of {table.getPageCount()}
                    </div>
                    <div className="space-x-2">
                        <Button variant="outline" size="sm" onClick={() => table.previousPage()} disabled={!table.getCanPreviousPage()}>
                            Previous
                        </Button>
                        <Button variant="outline" size="sm" onClick={() => table.nextPage()} disabled={!table.getCanNextPage()}>
                            Next
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    );
}
