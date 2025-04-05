@extends('Backend.Layout.App')
@section('title', 'Industrial Network Diagram')

@section('style')
<style>
    #industrialDiagram {
        width: 100%;
        height: 600px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <h4 class="mb-3 text-primary">📡 Industrial Network Diagram</h4>
    <div id="industrialDiagram"></div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/gojs/release/go.js"></script>
<script>
    function init() {
        const $ = go.GraphObject.make;

        const diagram = $(go.Diagram, "industrialDiagram", {
            "undoManager.isEnabled": true,
            layout: $(go.LayeredDigraphLayout, { direction: 0, layerSpacing: 50 })
        });

        // Node template with a modern card look
        diagram.nodeTemplate =
            $(go.Node, "Auto",
                { locationSpot: go.Spot.Center },
                $(go.Shape, "RoundedRectangle", {
                    fill: "#ffffff",
                    stroke: "#007bff",
                    strokeWidth: 2,
                    shadowVisible: true
                }),
                $(go.Panel, "Vertical",
                    { margin: 8 },
                    $(go.TextBlock, {
                        font: "bold 14px Roboto, sans-serif",
                        stroke: "#333",
                        margin: new go.Margin(4, 0, 4, 0)
                    }, new go.Binding("text", "name")),
                    $(go.TextBlock, {
                        font: "12px sans-serif",
                        stroke: "#555"
                    }, new go.Binding("text", "type"))
                )
            );

        // Link style
        diagram.linkTemplate =
            $(go.Link,
                { routing: go.Link.AvoidsNodes, curve: go.Link.JumpOver, corner: 8 },
                $(go.Shape, { stroke: "#007bff", strokeWidth: 2 }),
                $(go.Shape, { toArrow: "Standard", fill: "#007bff", stroke: null })
            );

        // Sample data
        diagram.model = new go.GraphLinksModel(
            [
                { key: 1, name: "Mikrotik Router", type: "Core Router" },
                { key: 2, name: "Switch A", type: "Managed Switch" },
                { key: 3, name: "Switch B", type: "Unmanaged Switch" },
                { key: 4, name: "PLC Controller", type: "Automation" },
                { key: 5, name: "Sensor", type: "Input Device" },
                { key: 6, name: "Camera", type: "IP Surveillance" },
                { key: 7, name: "Server", type: "Data Server" }
            ],
            [
                { from: 1, to: 2 },
                { from: 1, to: 3 },
                { from: 2, to: 4 },
                { from: 2, to: 5 },
                { from: 3, to: 6 },
                { from: 3, to: 7 }
            ]
        );
    }

    window.addEventListener('DOMContentLoaded', init);
</script>
@endsection
