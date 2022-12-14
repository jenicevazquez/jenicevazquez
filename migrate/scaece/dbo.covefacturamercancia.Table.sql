/****** Object:  Table [dbo].[covefacturamercancia]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[covefacturamercancia](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[descripcionGenerica] [varchar](1000) NULL,
	[claveUnidadMedida] [varchar](50) NULL,
	[tipoMoneda] [varchar](50) NULL,
	[cantidad] [decimal](18, 6) NULL,
	[valorUnitario] [decimal](18, 2) NULL,
	[valorTotal] [decimal](18, 2) NULL,
	[valorDolares] [decimal](18, 2) NULL,
	[covefactura_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_covefacturamercancia] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
