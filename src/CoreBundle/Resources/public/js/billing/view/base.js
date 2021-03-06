define(
    ['marionette', 'lodash', 'core/billing/model/row_model', 'core/billing/view/footer', 'core/billing/view/item_row'],
    function (Mn, _, RowModel, FooterView, RowView)
    {
        return Mn.CollectionView.extend({
            childView: RowView,
            el: null,
            footerView: null,
            counter: 0,
            hasTax: null,
            templateContext: function() {
                return { hasTax: this.hasTax };
            },
            initialize: function (options) {
                this.footerView = options.footerView;
                this.el = options.selector;
                this.fieldData = options.fieldData;
                this.counter = this.collection.size();
                this.hasTax = options.hasTax;
            },
            ui: {
                'addItem': '.add-item'
            },
            events: {
                'click @ui.addItem': 'addItem'
            },
            collectionEvents: {
                "update:totals": "renderTotals"
            },
            renderTotals: function() {
                var footer = this.$(this.el);

                setTimeout(_.bind(function() {
                    footer.empty();
                    this.footerView.render().$el.find('tr').appendTo(footer);
                }, this), 0);
            },
            onRender: function() {
                this.footerView.render().$el.find('tr').appendTo(this.$(this.el));
            },
            addItem: function(event) {
                event.preventDefault();

                this.collection.add(new RowModel({
                    id: this.counter++,
                    fields: this.fieldData
                }));
            }
        });
    }
);